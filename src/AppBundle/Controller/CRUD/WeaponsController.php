<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/24/16
 * Time: 7:26 PM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Entity\Weapon;
use AppBundle\Form\AddWeaponForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */

class WeaponsController extends Controller
{
    /**
     * @Route("/weapon/show/{weaponName}", name="weapon_show")
     */
    public function showWeaponAction(Weapon $weapon){
        return $this->render('crud/weapons/show.html.twig', [
            'weapon' => $weapon
        ]);
    }

    /**
     * @Route("/weapon/list", name="weapon_list")
     */
    public function listWeaponAction(){
        $em = $this->getDoctrine()->getManager();

        $weapons = $em->getRepository('AppBundle:Weapon')
            ->findAll();

        return $this->render('crud/weapons/list.html.twig', [
            'weapons' => $weapons
        ]);
    }

    /**
     * @Route("/weapon/add", name="weapon_add")
     */
    public function addWeaponAction(Request $request){
        $form = $this->createForm(AddWeaponForm::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->persistWeapon($form);

            return $this->redirectToRoute('weapon_list');
        }

        return $this->render('crud/weapons/new.html.twig', [
            'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/weapon/edit/{weaponName}", name="weapon_edit")
     */
    public function editWeaponAction(Request $request, Weapon $weapon){
        $form = $this->createForm(AddWeaponForm::class, $weapon);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->persistWeapon($form);

            return $this->redirectToRoute('weapon_list');
        }

        return $this->render('crud/weapons/edit.html.twig', [
           'form' => $form->createView(),
            'weapon' => $weapon
        ]);
    }

    /**
     * @Route("/weapon/remove/{id}", name="weapon_remove")
     */
    public function removeWeaponAction($id){
        $em = $this->getDoctrine()->getManager();

        $weapon = $em->getRepository('Weapon.php')->find($id);

        $em->remove($weapon);
        $em->flush();

        return $this->redirectToRoute('weapon_list');
    }

    private function persistWeapon(Form $form){
        $em = $this->getDoctrine()->getManager();
        $weapon = $form->getData();

        $em->persist($weapon);
        $em->flush();
    }
}