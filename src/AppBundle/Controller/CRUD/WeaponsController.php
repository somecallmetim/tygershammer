<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/24/16
 * Time: 7:26 PM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\AbstractCRUDEntity;
use AppBundle\Entity\Weapon;
use AppBundle\Form\AddWeaponForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */

class WeaponsController extends AbstractCRUDController
{
    /**
     * @Route("/weapon/list", name="list_weapons")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $weapons = $em->getRepository('AppBundle:Weapon')
            ->findAll();
        
        $attributes = $this->serialize($weapons[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $weaponsArray = array();

        foreach($weapons as $weapon){
            $weaponsArray[] = $this->serialize($weapon);
        }

        return $this->render('crud/weapons/list.html.twig', [
            'entities' => $weaponsArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("/weapon/show/{name}", name="show_weapon")
     */
    public function showAction(Weapon $weapon){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($weapon);
        return $this->render('crud/weapons/show.html.twig', [
            'entity' => $weapon,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Route("/weapon/add", name="add_weapon")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddWeaponForm::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->persistWeapon($form);

            return $this->redirectToRoute('list_weapons');
        }

        return $this->render('crud/weapons/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
            ]);
    }

    /**
     * @Route("/weapon/edit/{name}", name="edit_weapon")
     */
    public function editAction(Request $request, Weapon $weapon){
        $form = $this->createForm(AddWeaponForm::class, $weapon);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->persistWeapon($form);

            return $this->redirectToRoute('list_weapons');
        }

        return $this->render('crud/weapons/edit.html.twig', [
           'form' => $form->createView(),
            'entity' => $weapon,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Route("/weapon/remove/{id}", name="delete_weapon")
     */
    public function removeAction($id){
        $em = $this->getDoctrine()->getManager();

        $weapon = $em->getRepository('Weapon.php')->find($id);

        $em->remove($weapon);
        $em->flush();

        return $this->redirectToRoute('list_weapons');
    }

    private function persistWeapon(Form $form){
        $em = $this->getDoctrine()->getManager();
        $weapon = $form->getData();

        $em->persist($weapon);
        $em->flush();
    }

    function setRoutes()
    {
        $this->routes = [
            'edit' => 'edit_weapon',
            'list' => 'list_weapons',
            'new'  => 'add_weapon',
            'show' => 'show_weapon',
            'delete' => 'delete_weapon'
        ];

        $this->twigForm = 'crud/weapons/_weaponForm.html.twig';
        $this->entityName = 'Weapon';
    }

    function serialize(Weapon $weapon){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($weapon);

        return $attributes;
    }
}