<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/4/17
 * Time: 11:44 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\Keyword;
use AppBundle\Form\AddKeywordForm;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class KeywordController extends AbstractCRUDController
{
    /**
     * @Route("/keywords", name="list_keywords")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $keywords = $em->getRepository('AppBundle:Keyword')
            ->findAll();

        $attributes = $this->serialize($keywords[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $keywordsArray = array();

        foreach($keywords as $keyword){
            $keywordsArray[] = $this->serialize($keyword);
        }

        return $this->render('crud/keywords/list.html.twig', [
            'entities' => $keywordsArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/keywords/{name}", name="show_keyword")
     */
    public function showAction(Keyword $keyword){
        $attributes = $this->serialize($keyword);
        return $this->render('crud/keywords/show.html.twig', [
            'entity' => $keyword,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/keywords_add", name="add_keywords")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddKeywordForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $keyword = $form->getData();

            $em->persist($keyword);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_keywords':'list_keywords';

            $this->addFlash('success', sprintf('%s successfully created!', $keyword->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/keywords/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/keywords/edit/{name}", name="edit_keyword")
     */
    public function editAction(Request $request, Keyword $keyword){
        $form = $this->createForm(AddKeywordForm::class, $keyword);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $keyword = $form->getData();

            $em->persist($keyword);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $keyword->getName()));

            return $this->redirectToRoute('list_keywords');
        }
        return $this->render('crud/keywords/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $keyword,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/keywords/delete/{id}", name="delete_keyword")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $keyword = $em->getRepository('AppBundle:Keyword')->find($id);
        $em->remove($keyword);
        $em->flush();
        return $this->redirectToRoute('list_keywords');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_keyword',
            'list'   => 'list_keywords',
            'new'    => 'add_keywords',
            'show'   => 'show_keyword',
            'delete' => 'delete_keyword'
        ];

        $this->twigForm = 'crud/keywords/_keywordsForm.html.twig';
        $this->entityName = 'Keyword';
    }

    function serialize(Keyword $keyword){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($keyword);
        return $attributes;
    }
}