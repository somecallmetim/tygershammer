<?php

namespace AppBundle\Controller\CRUD;

use AppBundle\Entity\PitchedBattleRuleEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pitchedbattleruleentity controller.
 *
 * @Route("pitchedBattleRules")
 */
class PitchedBattleRuleEntityController extends Controller
{
    /**
     * Lists all pitchedBattleRuleEntity entities.
     *
     * @Route("/", name="pitchedBattleRules_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pitchedBattleRuleEntities = $em->getRepository('AppBundle:PitchedBattleRuleEntity')->findAll();

        return $this->render('crud/pitchedBattleRules/index.html.twig', array(
            'pitchedBattleRuleEntities' => $pitchedBattleRuleEntities,
        ));
    }

    /**
     * Creates a new pitchedBattleRuleEntity entity.
     *
     * @Route("/new", name="pitchedBattleRules_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pitchedBattleRuleEntity = new Pitchedbattleruleentity();
        $form = $this->createForm('AppBundle\Form\PitchedBattleRuleEntityType', $pitchedBattleRuleEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pitchedBattleRuleEntity);
            $em->flush($pitchedBattleRuleEntity);

            return $this->redirectToRoute('pitchedBattleRules_show', array('id' => $pitchedBattleRuleEntity->getId()));
        }

        return $this->render('crud/pitchedBattleRules/new.html.twig', array(
            'pitchedBattleRuleEntity' => $pitchedBattleRuleEntity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pitchedBattleRuleEntity entity.
     *
     * @Route("/{id}", name="pitchedBattleRules_show")
     * @Method("GET")
     */
    public function showAction(PitchedBattleRuleEntity $pitchedBattleRuleEntity)
    {
        $deleteForm = $this->createDeleteForm($pitchedBattleRuleEntity);

        return $this->render('crud/pitchedBattleRules/show.html.twig', array(
            'pitchedBattleRuleEntity' => $pitchedBattleRuleEntity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pitchedBattleRuleEntity entity.
     *
     * @Route("/{id}/edit", name="pitchedBattleRules_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PitchedBattleRuleEntity $pitchedBattleRuleEntity)
    {
        $deleteForm = $this->createDeleteForm($pitchedBattleRuleEntity);
        $editForm = $this->createForm('AppBundle\Form\PitchedBattleRuleEntityType', $pitchedBattleRuleEntity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pitchedBattleRules_edit', array('id' => $pitchedBattleRuleEntity->getId()));
        }

        return $this->render('crud/pitchedBattleRules/edit.html.twig', array(
            'pitchedBattleRuleEntity' => $pitchedBattleRuleEntity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pitchedBattleRuleEntity entity.
     *
     * @Route("/{id}", name="pitchedBattleRules_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PitchedBattleRuleEntity $pitchedBattleRuleEntity)
    {
        $form = $this->createDeleteForm($pitchedBattleRuleEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pitchedBattleRuleEntity);
            $em->flush($pitchedBattleRuleEntity);
        }

        return $this->redirectToRoute('pitchedBattleRules_index');
    }

    /**
     * Creates a form to delete a pitchedBattleRuleEntity entity.
     *
     * @param PitchedBattleRuleEntity $pitchedBattleRuleEntity The pitchedBattleRuleEntity entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PitchedBattleRuleEntity $pitchedBattleRuleEntity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pitchedBattleRules_delete', array('id' => $pitchedBattleRuleEntity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
