<?php
namespace JobBundle\EventListener;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JobBundle\Entity\Job;
use JobBundle\State\State;
use MailerBundle\Service\MailerService;

/**
 * Class MailerListener
 * @package JobBundle\EventListener
 */
class MailerListener
{
    /**
     * @var MailerService
     */
    private $mailerService;

    /**
     * @var string
     */
    private $moderatorEmail;

    /**
     * @var string
     */
    private $latestPostedJobStatus;

    /**
     * @var array
     */
    private $jobs = [];


    /**
     * MailerListener constructor.
     * @param MailerService $mailer
     * @param $moderatorEmail
     */
    public function __construct(MailerService $mailer, $moderatorEmail)
    {
        $this->mailerService = $mailer;
        $this->moderatorEmail = $moderatorEmail;
        $this->latestPostedJobStatus = State::STATE_PENDING;

    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Job) {
            return;
        }

        $entityManager = $args->getEntityManager();

        $this->getJobsByEmail($entity, $entityManager);
        $this->setEmailToJobsBoardModerator($entity);
        $this->setJobStatus($entity, $entityManager);
        $this->sendEmailToHr($entity->getEmail());
    }

    /**
     * @param Job $entity
     * @param EntityManager $em
     */
    private function getJobsByEmail(Job $entity, EntityManager $em)
    {
        $this->jobs = $em->getRepository('JobBundle:Job')
            ->findBy(['email' => $entity->getEmail()], ['id' => 'DESC']);
    }

    /**
     * @param Job $job
     */
    private function setEmailToJobsBoardModerator(Job $job)
    {
        if (!empty($this->jobs) && count($this->jobs) == 1) {
            $this->mailerService->send($this->moderatorEmail, "A new job has been posted.", "moderator_email_message.html.twig", ['id' => $job->getId(), 'title' => $job->getTitle(), 'description' => $job->getDescription(), 'email' => $this->moderatorEmail]);
        }
    }

    /**
     * @param Job $job
     * @param EntityManager $em
     */
    private function setJobStatus(Job $job, EntityManager $em)
    {
        if (!empty($this->jobs) && count($this->jobs) > 1) {
            $row = reset($this->jobs);
            $this->latestPostedJobStatus = $row->getStatus();
            $job->setStatus($this->latestPostedJobStatus);
            $em->persist($job);
            $em->flush();
        }

    }

    /**
     * @param $email
     */
    private function sendEmailToHr($email)
    {
        $this->mailerService->send($email, "Your job has been saved successfully.", "hr_email_message.html.twig", ['message' => $this->getHrMessage()]);
    }

    /**
     * @return string
     */
    private function getHrMessage()
    {
        return $this->latestPostedJobStatus == State::STATE_PUBLIC ? " published." : " posted. Your submission is in moderation.";
    }
}