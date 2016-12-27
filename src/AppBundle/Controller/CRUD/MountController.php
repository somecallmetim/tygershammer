<?php

namespace AppBundle\Controller\CRUD;

use AppBundle\Entity\Mount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mount controller.
 *
 * @Route("mount")
 */
class MountController extends Controller
{
    /**
     * Lists all mount entities.
     *
     * @Route("/", name="mount_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mounts = $em->getRepository('AppBundle:Mount')->findAll();

        return $this->render('crud/mount/index.html.twig', array(
            'mounts' => $mounts,
        ));
    }

    /**
     * Creates a new mount entity.
     *
     * @Route("/new", name="mount_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mount = new Mount();
        $form = $this->createForm('AppBundle\Form\MountType', $mount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mount);
            $em->flush($mount);

            return $this->redirectToRoute('mount_show', array('id' => $mount->getId()));
        }

        return $this->render('crud/mount/new.html.twig', array(
            'mount' => $mount,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mount entity.
     *
     * @Route("/{id}", name="mount_show")
     * @Method("GET")
     */
    public function showAction(Mount $mount)
    {
        $deleteForm = $this->createDeleteForm($mount);

        return $this->render('crud/mount/show.html.twig', array(
            'mount' => $mount,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mount entity.
     *
     * @Route("/{id}/edit", name="mount_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mount $mount)
    {
        $deleteForm = $this->createDeleteForm($mount);
        $editForm = $this->createForm('AppBundle\Form\MountType', $mount);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mount_edit', array('id' => $mount->getId()));
        }

        return $this->render('crud/mount/edit.html.twig', array(
            'mount' => $mount,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mount entity.
     *
     * @Route("/{id}", name="mount_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mount $mount)
    {
        $form = $this->createDeleteForm($mount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mount);
            $em->flush($mount);
        }

        return $this->redirectToRoute('mount_index');
    }

    /**
     * Creates a form to delete a mount entity.
     *
     * @param Mount $mount The mount entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mount $mount)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mount_delete', array('id' => $mount->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
