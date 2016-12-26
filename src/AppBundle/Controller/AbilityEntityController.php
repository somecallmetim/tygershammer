<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AbilityEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Abilityentity controller.
 *
 * @Route("ability")
 */
class AbilityEntityController extends Controller
{
    /**
     * Lists all abilityEntity entities.
     *
     * @Route("/", name="ability_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $abilityEntities = $em->getRepository('AppBundle:AbilityEntity')->findAll();

        return $this->render('ability/index.html.twig', array(
            'abilityEntities' => $abilityEntities,
        ));
    }

    /**
     * Creates a new abilityEntity entity.
     *
     * @Route("/new", name="ability_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $abilityEntity = new Abilityentity();
        $form = $this->createForm('AppBundle\Form\AbilityEntityType', $abilityEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($abilityEntity);
            $em->flush($abilityEntity);

            return $this->redirectToRoute('ability_show', array('id' => $abilityEntity->getId()));
        }

        return $this->render('ability/new.html.twig', array(
            'abilityEntity' => $abilityEntity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a abilityEntity entity.
     *
     * @Route("/{id}", name="ability_show")
     * @Method("GET")
     */
    public function showAction(AbilityEntity $abilityEntity)
    {
        $deleteForm = $this->createDeleteForm($abilityEntity);

        return $this->render('ability/show.html.twig', array(
            'abilityEntity' => $abilityEntity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing abilityEntity entity.
     *
     * @Route("/{id}/edit", name="ability_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AbilityEntity $abilityEntity)
    {
        $deleteForm = $this->createDeleteForm($abilityEntity);
        $editForm = $this->createForm('AppBundle\Form\AbilityEntityType', $abilityEntity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ability_edit', array('id' => $abilityEntity->getId()));
        }

        return $this->render('ability/edit.html.twig', array(
            'abilityEntity' => $abilityEntity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a abilityEntity entity.
     *
     * @Route("/{id}", name="ability_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AbilityEntity $abilityEntity)
    {
        $form = $this->createDeleteForm($abilityEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abilityEntity);
            $em->flush($abilityEntity);
        }

        return $this->redirectToRoute('ability_index');
    }

    /**
     * Creates a form to delete a abilityEntity entity.
     *
     * @param AbilityEntity $abilityEntity The abilityEntity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AbilityEntity $abilityEntity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ability_delete', array('id' => $abilityEntity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
