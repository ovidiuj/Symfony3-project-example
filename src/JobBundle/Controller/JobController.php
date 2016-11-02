<?php

namespace JobBundle\Controller;

use JobBundle\Entity\Job;
use JobBundle\State\State;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Job controller.
 *
 */
class JobController extends Controller
{
    /**
     * Lists all job entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jobs = $em->getRepository('JobBundle:Job')->findAll();

        return $this->render('job/index.html.twig', array(
            'jobs' => $jobs,
        ));
    }

    /**
     * Creates a new job entity.
     *
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $form = $this->createForm('JobBundle\Form\JobType', $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush($job);

            return $this->redirectToRoute('job_show', array('id' => $job->getId()));
        }

        return $this->render('job/new.html.twig', array(
            'job' => $job,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a job entity.
     *
     */
    public function showAction(Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);

        return $this->render('job/show.html.twig', array(
            'job' => $job,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing job entity.
     *
     */
    public function editAction(Request $request, Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm('JobBundle\Form\JobType', $job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job_edit', array('id' => $job->getId()));
        }

        return $this->render('job/edit.html.twig', array(
            'job' => $job,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a job entity.
     *
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush($job);
        }

        return $this->redirectToRoute('job_index');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function publishAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository('JobBundle:Job')
            ->find($id);

        if (!$job) {
            throw $this->createNotFoundException(
                'No job found for id ' . $id
            );
        }

        $job->setStatus(State::STATE_PUBLIC);
        $em->persist($job);
        $em->flush();

        return $this->render('job/publish.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function spamAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository('JobBundle:Job')
            ->find($id);

        if (!$job) {
            throw $this->createNotFoundException(
                'No job found for id ' . $id
            );
        }

        $job->setStatus(State::STATE_SPAM);
        $em->persist($job);
        $em->flush();

        return $this->render('job/spam.html.twig');
    }

    /**
     * Creates a form to delete a job entity.
     *
     * @param Job $job The job entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('job_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
