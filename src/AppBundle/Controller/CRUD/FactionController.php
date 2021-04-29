<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/3/17
 * Time: 11:34 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\Faction;
use AppBundle\Form\AddFactionForm;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class FactionController extends AbstractCRUDController
{
    /**
     * @Route("/factions", name="list_factions")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $factions = $em->getRepository('AppBundle:Faction')
            ->findAll();

        $attributes = $this->serialize($factions[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $factionsArray = array();

        foreach($factions as $faction){
            $factionsArray[] = $this->serialize($faction);
        }

        return $this->render('crud/factions/list.html.twig', [
            'entities' => $factionsArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/factions/{name}", name="show_faction")
     */
    public function showAction(Faction $faction){
        $attributes = $this->serialize($faction);
        return $this->render('crud/factions/show.html.twig', [
            'entity' => $faction,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/factions_add", name="add_factions")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddFactionForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $faction = $form->getData();

            $em->persist($faction);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_factions':'list_factions';

            $this->addFlash('success', sprintf('%s successfully created!', $faction->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/factions/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/factions/edit/{name}", name="edit_faction")
     */
    public function editAction(Request $request, Faction $faction){
        $form = $this->createForm(AddFactionForm::class, $faction);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $faction = $form->getData();

            $em->persist($faction);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $faction->getName()));

            return $this->redirectToRoute('list_factions');
        }
        return $this->render('crud/factions/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $faction,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/factions/delete/{id}", name="delete_faction")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $faction = $em->getRepository('AppBundle:Faction')->find($id);
        $em->remove($faction);
        $em->flush();
        return $this->redirectToRoute('list_factions');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_faction',
            'list'   => 'list_factions',
            'new'    => 'add_factions',
            'show'   => 'show_faction',
            'delete' => 'delete_faction'
        ];

        $this->twigForm = 'crud/factions/_factionsForm.html.twig';
        $this->entityName = 'Faction';
    }

    function serialize(Faction $faction){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($faction);
        return $attributes;
    }
}