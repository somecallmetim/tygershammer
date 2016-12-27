<?php

namespace AppBundle\Controller\CRUD;

use AppBundle\Entity\BattlefieldRole;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Battlefieldrole controller.
 *
 * @Route("battlefieldrole")
 */
class BattlefieldRoleController extends Controller
{
    /**
     * Lists all battlefieldRole entities.
     *
     * @Route("/", name="battlefieldrole_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $battlefieldRoles = $em->getRepository('AppBundle:BattlefieldRole')->findAll();

        return $this->render('crud/battlefieldrole/index.html.twig', array(
            'battlefieldRoles' => $battlefieldRoles,
        ));
    }

    /**
     * Creates a new battlefieldRole entity.
     *
     * @Route("/new", name="battlefieldrole_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $battlefieldRole = new Battlefieldrole();
        $form = $this->createForm('AppBundle\Form\BattlefieldRoleType', $battlefieldRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($battlefieldRole);
            $em->flush($battlefieldRole);

            return $this->redirectToRoute('battlefieldrole_show', array('id' => $battlefieldRole->getId()));
        }

        return $this->render('crud/battlefieldrole/new.html.twig', array(
            'battlefieldRole' => $battlefieldRole,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a battlefieldRole entity.
     *
     * @Route("/{id}", name="battlefieldrole_show")
     * @Method("GET")
     */
    public function showAction(BattlefieldRole $battlefieldRole)
    {
        $deleteForm = $this->createDeleteForm($battlefieldRole);

        return $this->render('crud/battlefieldrole/show.html.twig', array(
            'battlefieldRole' => $battlefieldRole,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing battlefieldRole entity.
     *
     * @Route("/{id}/edit", name="battlefieldrole_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BattlefieldRole $battlefieldRole)
    {
        $deleteForm = $this->createDeleteForm($battlefieldRole);
        $editForm = $this->createForm('AppBundle\Form\BattlefieldRoleType', $battlefieldRole);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('battlefieldrole_edit', array('id' => $battlefieldRole->getId()));
        }

        return $this->render('crud/battlefieldrole/edit.html.twig', array(
            'battlefieldRole' => $battlefieldRole,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a battlefieldRole entity.
     *
     * @Route("/{id}", name="battlefieldrole_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BattlefieldRole $battlefieldRole)
    {
        $form = $this->createDeleteForm($battlefieldRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($battlefieldRole);
            $em->flush($battlefieldRole);
        }

        return $this->redirectToRoute('battlefieldrole_index');
    }

    /**
     * Creates a form to delete a battlefieldRole entity.
     *
     * @param BattlefieldRole $battlefieldRole The battlefieldRole entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BattlefieldRole $battlefieldRole)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('battlefieldrole_delete', array('id' => $battlefieldRole->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
