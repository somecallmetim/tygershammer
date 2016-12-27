<?php

namespace AppBundle\Controller\CRUD;

use AppBundle\Entity\Alliance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Alliance controller.
 *
 * @Route("alliance")
 */
class AllianceController extends Controller
{
    /**
     * Lists all alliance entities.
     *
     * @Route("/", name="alliance_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $alliances = $em->getRepository('AppBundle:Alliance')->findAll();

        return $this->render('crud/alliance/index.html.twig', array(
            'alliances' => $alliances,
        ));
    }

    /**
     * Creates a new alliance entity.
     *
     * @Route("/new", name="alliance_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $alliance = new Alliance();
        $form = $this->createForm('AppBundle\Form\AllianceType', $alliance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($alliance);
            $em->flush($alliance);

            return $this->redirectToRoute('alliance_show', array('id' => $alliance->getId()));
        }

        return $this->render('crud/alliance/new.html.twig', array(
            'alliance' => $alliance,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a alliance entity.
     *
     * @Route("/{id}", name="alliance_show")
     * @Method("GET")
     */
    public function showAction(Alliance $alliance)
    {
        $deleteForm = $this->createDeleteForm($alliance);

        return $this->render('crud/alliance/show.html.twig', array(
            'alliance' => $alliance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing alliance entity.
     *
     * @Route("/{id}/edit", name="alliance_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Alliance $alliance)
    {
        $deleteForm = $this->createDeleteForm($alliance);
        $editForm = $this->createForm('AppBundle\Form\AllianceType', $alliance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alliance_edit', array('id' => $alliance->getId()));
        }

        return $this->render('crud/alliance/edit.html.twig', array(
            'alliance' => $alliance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a alliance entity.
     *
     * @Route("/{id}", name="alliance_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Alliance $alliance)
    {
        $form = $this->createDeleteForm($alliance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($alliance);
            $em->flush($alliance);
        }

        return $this->redirectToRoute('alliance_index');
    }

    /**
     * Creates a form to delete a alliance entity.
     *
     * @param Alliance $alliance The alliance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Alliance $alliance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alliance_delete', array('id' => $alliance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
