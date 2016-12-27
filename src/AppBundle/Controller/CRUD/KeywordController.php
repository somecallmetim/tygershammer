<?php

namespace AppBundle\Controller\CRUD;

use AppBundle\Entity\Keyword;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Keyword controller.
 *
 * @Route("keyword")
 */
class KeywordController extends Controller
{
    /**
     * Lists all keyword entities.
     *
     * @Route("/", name="keyword_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $keywords = $em->getRepository('AppBundle:Keyword')->findAll();

        return $this->render('crud/keyword/index.html.twig', array(
            'keywords' => $keywords,
        ));
    }

    /**
     * Creates a new keyword entity.
     *
     * @Route("/new", name="keyword_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $keyword = new Keyword();
        $form = $this->createForm('AppBundle\Form\KeywordType', $keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($keyword);
            $em->flush($keyword);

            return $this->redirectToRoute('keyword_show', array('id' => $keyword->getId()));
        }

        return $this->render('crud/keyword/new.html.twig', array(
            'keyword' => $keyword,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a keyword entity.
     *
     * @Route("/{id}", name="keyword_show")
     * @Method("GET")
     */
    public function showAction(Keyword $keyword)
    {
        $deleteForm = $this->createDeleteForm($keyword);

        return $this->render('crud/keyword/show.html.twig', array(
            'keyword' => $keyword,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing keyword entity.
     *
     * @Route("/{id}/edit", name="keyword_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Keyword $keyword)
    {
        $deleteForm = $this->createDeleteForm($keyword);
        $editForm = $this->createForm('AppBundle\Form\KeywordType', $keyword);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('keyword_edit', array('id' => $keyword->getId()));
        }

        return $this->render('crud/keyword/edit.html.twig', array(
            'keyword' => $keyword,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a keyword entity.
     *
     * @Route("/{id}", name="keyword_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Keyword $keyword)
    {
        $form = $this->createDeleteForm($keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($keyword);
            $em->flush($keyword);
        }

        return $this->redirectToRoute('keyword_index');
    }

    /**
     * Creates a form to delete a keyword entity.
     *
     * @param Keyword $keyword The keyword entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Keyword $keyword)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('keyword_delete', array('id' => $keyword->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
