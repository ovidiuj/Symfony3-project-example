<?php

namespace MailerBundle\Service;


use Symfony\Component\Templating\EngineInterface;

/**
 * Class MailerService
 * @package MailerBundle\Service
 */
class MailerService implements MailerServiceInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var array
     */
    protected $sender;

    /**
     * @var EngineInterface
     */
    protected $twig;

    /**
     * @var string
     */
    protected $templatePath;

    /**
     * {@inheritdoc}
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, $sender, $templatePath = null)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->sender = $sender;
        $this->templatePath = $templatePath;
    }

    /**
     * {@inheritdoc}
     */
    public function send(
        $addresses,
        $subject = null,
        $template,
        array $templateParameters = [],
        array $sender = null,
        $contentType = 'text/html',
        $charset = null
    )
    {
        $body = $this->twig->render(
            $this->templatePath . $template,
            $templateParameters
        );


        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setTo($addresses)
            ->setBody($body, $contentType, $charset);

        // Default sender
        if ($sender == null) {
            $sender = $this->sender;
        }

        $message->setFrom($sender['address'], $sender['name']);

        return $this->mailer->send($message);
    }

    /**
     * Get sender
     * return array
     */
    public function getSender()
    {
        return $this->getSender();
    }
}