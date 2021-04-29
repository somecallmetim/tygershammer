<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/4/17
 * Time: 11:09 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\BattlefieldRole;
use AppBundle\Form\AddBattlefieldRoleForm;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class BattlefieldRoleController extends AbstractCRUDController
{
    /**
     * @Route("/battlefieldRoles", name="list_battlefieldRoles")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $battlefieldRoles = $em->getRepository('AppBundle:BattlefieldRole')
            ->findAll();

        $attributes = $this->serialize($battlefieldRoles[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $battlefieldRolesArray = array();

        foreach($battlefieldRoles as $battlefieldRole){
            $battlefieldRolesArray[] = $this->serialize($battlefieldRole);
        }

        return $this->render('crud/battlefieldRoles/list.html.twig', [
            'entities' => $battlefieldRolesArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/battlefieldRoles/{name}", name="show_battlefieldRole")
     */
    public function showAction(BattlefieldRole $battlefieldRole){
        $attributes = $this->serialize($battlefieldRole);
        return $this->render('crud/battlefieldRoles/show.html.twig', [
            'entity' => $battlefieldRole,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/battlefieldRoles_add", name="add_battlefieldRoles")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddBattlefieldRoleForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $battlefieldRole = $form->getData();

            $em->persist($battlefieldRole);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_battlefieldRoles':'list_battlefieldRoles';

            $this->addFlash('success', sprintf('%s successfully created!', $battlefieldRole->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/battlefieldRoles/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/battlefieldRoles/edit/{name}", name="edit_battlefieldRole")
     */
    public function editAction(Request $request, BattlefieldRole $battlefieldRole){
        $form = $this->createForm(AddBattlefieldRoleForm::class, $battlefieldRole);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $battlefieldRole = $form->getData();

            $em->persist($battlefieldRole);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $battlefieldRole->getName()));

            return $this->redirectToRoute('list_battlefieldRoles');
        }
        return $this->render('crud/battlefieldRoles/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $battlefieldRole,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/battlefieldRoles/delete/{id}", name="delete_battlefieldRole")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $battlefieldRole = $em->getRepository('AppBundle:BattlefieldRole')->find($id);
        $em->remove($battlefieldRole);
        $em->flush();
        return $this->redirectToRoute('list_battlefieldRoles');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_battlefieldRole',
            'list'   => 'list_battlefieldRoles',
            'new'    => 'add_battlefieldRoles',
            'show'   => 'show_battlefieldRole',
            'delete' => 'delete_battlefieldRole'
        ];

        $this->twigForm = 'crud/battlefieldRoles/_battlefieldRolesForm.html.twig';
        $this->entityName = 'BattlefieldRole';
    }

    function serialize(BattlefieldRole $battlefieldRole){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($battlefieldRole);
        return $attributes;
    }
}