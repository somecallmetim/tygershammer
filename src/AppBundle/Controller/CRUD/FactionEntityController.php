<?php

namespace AppBundle\Controller\CRUD;

use AppBundle\Entity\FactionEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Factionentity controller.
 *
 * @Route("faction")
 */
class FactionEntityController extends Controller
{
    /**
     * Lists all factionEntity entities.
     *
     * @Route("/", name="faction_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $factionEntities = $em->getRepository('AppBundle:FactionEntity')->findAll();

        return $this->render('crud/faction/index.html.twig', array(
            'factionEntities' => $factionEntities,
        ));
    }

    /**
     * Creates a new factionEntity entity.
     *
     * @Route("/new", name="faction_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $factionEntity = new Factionentity();
        $form = $this->createForm('AppBundle\Form\FactionEntityType', $factionEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($factionEntity);
            $em->flush($factionEntity);

            return $this->redirectToRoute('faction_show', array('id' => $factionEntity->getId()));
        }

        return $this->render('crud/faction/new.html.twig', array(
            'factionEntity' => $factionEntity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a factionEntity entity.
     *
     * @Route("/{id}", name="faction_show")
     * @Method("GET")
     */
    public function showAction(FactionEntity $factionEntity)
    {
        $deleteForm = $this->createDeleteForm($factionEntity);

        return $this->render('crud/faction/show.html.twig', array(
            'factionEntity' => $factionEntity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing factionEntity entity.
     *
     * @Route("/{id}/edit", name="faction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FactionEntity $factionEntity)
    {
        $deleteForm = $this->createDeleteForm($factionEntity);
        $editForm = $this->createForm('AppBundle\Form\FactionEntityType', $factionEntity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('faction_edit', array('id' => $factionEntity->getId()));
        }

        return $this->render('crud/faction/edit.html.twig', array(
            'factionEntity' => $factionEntity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a factionEntity entity.
     *
     * @Route("/{id}", name="faction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FactionEntity $factionEntity)
    {
        $form = $this->createDeleteForm($factionEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($factionEntity);
            $em->flush($factionEntity);
        }

        return $this->redirectToRoute('faction_index');
    }

    /**
     * Creates a form to delete a factionEntity entity.
     *
     * @param FactionEntity $factionEntity The factionEntity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FactionEntity $factionEntity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faction_delete', array('id' => $factionEntity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
