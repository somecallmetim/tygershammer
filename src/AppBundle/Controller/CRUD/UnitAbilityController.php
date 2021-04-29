<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 1/31/17
 * Time: 6:17 PM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;

use AppBundle\Entity\UnitAbility;
use AppBundle\Form\AddUnitAbilityForm;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class UnitAbilityController extends AbstractCRUDController
{
    /**
     * @Route("/unitAbilities", name="list_unitAbilities")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $unitAbilities = $em->getRepository('AppBundle:UnitAbility')
            ->findAll();

        $attributes = $this->serialize($unitAbilities[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $unitAbilitiesArray = array();

        foreach($unitAbilities as $unitAbility){
            $unitAbilitiesArray[] = $this->serialize($unitAbility);
        }

        return $this->render('crud/unitAbilities/list.html.twig', [
            'entities' => $unitAbilitiesArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/unitAbilities/{name}", name="show_unitAbilities")
     */
    public function showAction(UnitAbility $unitAbility){
        $attributes = $this->serialize($unitAbility);
        return $this->render('crud/unitAbilities/show.html.twig', [
            'entity' => $unitAbility,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/unitAbilities_add", name="add_unitAbilities")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddUnitAbilityForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $unitAbility = $form->getData();

            $em->persist($unitAbility);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully created!', $unitAbility->getName()));

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_unitAbilities':'list_unitAbilities';

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/unitAbilities/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/unitAbilities/edit/{name}", name="edit_unitAbilities")
     */
    public function editAction(Request $request, UnitAbility $unitAbility){
        $form = $this->createForm(AddUnitABilityForm::class, $unitAbility);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $unitAbility = $form->getData();

            $em->persist($unitAbility);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $unitAbility->getName()));
            return $this->redirectToRoute('list_unitAbilities');
        }
        return $this->render('crud/unitAbilities/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $unitAbility,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/unitAbilities/delete/{id}", name="delete_unitAbilities")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $unitAbility = $em->getRepository('AppBundle:UnitAbility')->find($id);
        $em->remove($unitAbility);
        $em->flush();
        return $this->redirectToRoute('list_unitAbilities');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_unitAbilities',
            'list'   => 'list_unitAbilities',
            'new'    => 'add_unitAbilities',
            'show'   => 'show_unitAbilities',
            'delete' => 'delete_unitAbilities'
        ];

        $this->twigForm = 'crud/unitAbilities/_unitAbilitiesForm.html.twig';
        $this->entityName = 'UnitAbility';
    }

    function serialize(UnitAbility $unitAbility){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($unitAbility);
        return $attributes;
    }

}