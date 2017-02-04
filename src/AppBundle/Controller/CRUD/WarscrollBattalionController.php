<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/4/17
 * Time: 11:56 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\WarscrollBattalion;
use AppBundle\Form\AddWarscrollBattalionForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class WarscrollBattalionController extends AbstractCRUDController
{
    /**
     * @Route("/warscrollBattalions", name="list_warscrollBattalions")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $warscrollBattalions = $em->getRepository('AppBundle:WarscrollBattalion')
            ->findAll();

        $attributes = $this->serialize($warscrollBattalions[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $warscrollBattalionsArray = array();

        foreach($warscrollBattalions as $warscrollBattalion){
            $warscrollBattalionsArray[] = $this->serialize($warscrollBattalion);
        }

        return $this->render('crud/warscrollBattalions/list.html.twig', [
            'entities' => $warscrollBattalionsArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/warscrollBattalions/{name}", name="show_warscrollBattalion")
     */
    public function showAction(WarscrollBattalion $warscrollBattalion){
        $attributes = $this->serialize($warscrollBattalion);
        return $this->render('crud/warscrollBattalions/show.html.twig', [
            'entity' => $warscrollBattalion,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/warscrollBattalions_add", name="add_warscrollBattalions")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddWarscrollBattalionForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $warscrollBattalion = $form->getData();

            $em->persist($warscrollBattalion);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_warscrollBattalions':'list_warscrollBattalions';

            $this->addFlash('success', sprintf('%s successfully created!', $warscrollBattalion->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/warscrollBattalions/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/warscrollBattalions/edit/{name}", name="edit_warscrollBattalion")
     */
    public function editAction(Request $request, WarscrollBattalion $warscrollBattalion){
        $form = $this->createForm(AddWarscrollBattalionForm::class, $warscrollBattalion);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $warscrollBattalion = $form->getData();

            $em->persist($warscrollBattalion);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $warscrollBattalion->getName()));

            return $this->redirectToRoute('list_warscrollBattalions');
        }
        return $this->render('crud/warscrollBattalions/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $warscrollBattalion,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/warscrollBattalions/delete/{id}", name="delete_warscrollBattalion")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $warscrollBattalion = $em->getRepository('AppBundle:WarscrollBattalion')->find($id);
        $em->remove($warscrollBattalion);
        $em->flush();
        return $this->redirectToRoute('list_warscrollBattalions');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_warscrollBattalion',
            'list'   => 'list_warscrollBattalions',
            'new'    => 'add_warscrollBattalions',
            'show'   => 'show_warscrollBattalion',
            'delete' => 'delete_warscrollBattalion'
        ];

        $this->twigForm = 'crud/warscrollBattalions/_warscrollBattalionsForm.html.twig';
        $this->entityName = 'WarscrollBattalion';
    }

    function serialize(WarscrollBattalion $warscrollBattalion){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($warscrollBattalion);
        return $attributes;
    }
}