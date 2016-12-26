<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SpellEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Spellentity controller.
 *
 * @Route("spell")
 */
class SpellEntityController extends Controller
{
    /**
     * Lists all spellEntity entities.
     *
     * @Route("/", name="spell_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $spellEntities = $em->getRepository('AppBundle:SpellEntity')->findAll();

        return $this->render('spell/index.html.twig', array(
            'spellEntities' => $spellEntities,
        ));
    }

    /**
     * Creates a new spellEntity entity.
     *
     * @Route("/new", name="spell_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $spellEntity = new Spellentity();
        $form = $this->createForm('AppBundle\Form\SpellEntityType', $spellEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spellEntity);
            $em->flush($spellEntity);

            return $this->redirectToRoute('spell_show', array('id' => $spellEntity->getId()));
        }

        return $this->render('spell/new.html.twig', array(
            'spellEntity' => $spellEntity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a spellEntity entity.
     *
     * @Route("/{id}", name="spell_show")
     * @Method("GET")
     */
    public function showAction(SpellEntity $spellEntity)
    {
        $deleteForm = $this->createDeleteForm($spellEntity);

        return $this->render('spell/show.html.twig', array(
            'spellEntity' => $spellEntity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing spellEntity entity.
     *
     * @Route("/{id}/edit", name="spell_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SpellEntity $spellEntity)
    {
        $deleteForm = $this->createDeleteForm($spellEntity);
        $editForm = $this->createForm('AppBundle\Form\SpellEntityType', $spellEntity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spell_edit', array('id' => $spellEntity->getId()));
        }

        return $this->render('spell/edit.html.twig', array(
            'spellEntity' => $spellEntity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a spellEntity entity.
     *
     * @Route("/{id}", name="spell_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SpellEntity $spellEntity)
    {
        $form = $this->createDeleteForm($spellEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spellEntity);
            $em->flush($spellEntity);
        }

        return $this->redirectToRoute('spell_index');
    }

    /**
     * Creates a form to delete a spellEntity entity.
     *
     * @param SpellEntity $spellEntity The spellEntity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SpellEntity $spellEntity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spell_delete', array('id' => $spellEntity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
