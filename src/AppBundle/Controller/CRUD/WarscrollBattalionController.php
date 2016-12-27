<?php

namespace AppBundle\Controller\CRUD;

use AppBundle\Entity\WarscrollBattalion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Warscrollbattalion controller.
 *
 * @Route("warscrollbattalion")
 */
class WarscrollBattalionController extends Controller
{
    /**
     * Lists all warscrollBattalion entities.
     *
     * @Route("/", name="warscrollbattalion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $warscrollBattalions = $em->getRepository('AppBundle:WarscrollBattalion')->findAll();

        return $this->render('crud/warscrollbattalion/index.html.twig', array(
            'warscrollBattalions' => $warscrollBattalions,
        ));
    }

    /**
     * Creates a new warscrollBattalion entity.
     *
     * @Route("/new", name="warscrollbattalion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $warscrollBattalion = new Warscrollbattalion();
        $form = $this->createForm('AppBundle\Form\WarscrollBattalionType', $warscrollBattalion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($warscrollBattalion);
            $em->flush($warscrollBattalion);

            return $this->redirectToRoute('warscrollbattalion_show', array('id' => $warscrollBattalion->getId()));
        }

        return $this->render('crud/warscrollbattalion/new.html.twig', array(
            'warscrollBattalion' => $warscrollBattalion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a warscrollBattalion entity.
     *
     * @Route("/{id}", name="warscrollbattalion_show")
     * @Method("GET")
     */
    public function showAction(WarscrollBattalion $warscrollBattalion)
    {
        $deleteForm = $this->createDeleteForm($warscrollBattalion);

        return $this->render('crud/warscrollbattalion/show.html.twig', array(
            'warscrollBattalion' => $warscrollBattalion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing warscrollBattalion entity.
     *
     * @Route("/{id}/edit", name="warscrollbattalion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, WarscrollBattalion $warscrollBattalion)
    {
        $deleteForm = $this->createDeleteForm($warscrollBattalion);
        $editForm = $this->createForm('AppBundle\Form\WarscrollBattalionType', $warscrollBattalion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('warscrollbattalion_edit', array('id' => $warscrollBattalion->getId()));
        }

        return $this->render('crud/warscrollbattalion/edit.html.twig', array(
            'warscrollBattalion' => $warscrollBattalion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a warscrollBattalion entity.
     *
     * @Route("/{id}", name="warscrollbattalion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, WarscrollBattalion $warscrollBattalion)
    {
        $form = $this->createDeleteForm($warscrollBattalion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($warscrollBattalion);
            $em->flush($warscrollBattalion);
        }

        return $this->redirectToRoute('warscrollbattalion_index');
    }

    /**
     * Creates a form to delete a warscrollBattalion entity.
     *
     * @param WarscrollBattalion $warscrollBattalion The warscrollBattalion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(WarscrollBattalion $warscrollBattalion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('warscrollbattalion_delete', array('id' => $warscrollBattalion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
