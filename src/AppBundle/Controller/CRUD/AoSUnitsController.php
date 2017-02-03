<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/17/16
 * Time: 12:55 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\Unit;
use AppBundle\Form\AddUnitForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class AoSUnitsController extends AbstractCRUDController
{
    /**
     * @Route("/units", name="list_units")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $units = $em->getRepository('AppBundle:Unit')
            ->findAll();

        $attributes = $this->serialize($units[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $unitsArray = array();

        foreach($units as $unit){
            $unitsArray[] = $this->serialize($unit);
        }

        return $this->render('crud/units/list.html.twig', [
            'entities' => $unitsArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/units/{name}", name="show_unit")
     */
    public function showAction(Unit $unit){
        $attributes = $this->serialize($unit);
        return $this->render('crud/units/show.html.twig', [
            'entity' => $unit,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/units_add", name="add_units")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddUnitForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $unit = $form->getData();

            $em->persist($unit);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully created!', $unit->getName()));

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_units':'list_units';

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/units/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/units/edit/{name}", name="edit_unit")
     */
    public function editAction(Request $request, Unit $unit){
        $form = $this->createForm(AddUnitForm::class, $unit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $unit = $form->getData();

            $em->persist($unit);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $unit->getName()));

            return $this->redirectToRoute('list_units');
        }
        return $this->render('crud/units/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $unit,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/units/delete/{id}", name="delete_unit")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $unit = $em->getRepository('AppBundle:Unit')->find($id);
        $em->remove($unit);
        $em->flush();
        return $this->redirectToRoute('list_units');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_unit',
            'list'   => 'list_units',
            'new'    => 'add_units',
            'show'   => 'show_unit',
            'delete' => 'delete_unit'
        ];

        $this->twigForm = 'crud/units/_unitsForm.html.twig';
        $this->entityName = 'Unit';
    }

    function serialize(Unit $unit){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($unit);
        $faction = $attributes['faction'];
        $attributes['faction'] = $faction['name'];
        return $attributes;
    }
}