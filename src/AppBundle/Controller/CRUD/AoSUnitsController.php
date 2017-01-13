<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/17/16
 * Time: 12:55 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Entity\Unit;
use AppBundle\Form\AddUnitForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AoSUnitsController extends Controller
{
    /**
     * @Route("/units", name="list_units")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $units = $em->getRepository('AppBundle:Unit')
            ->findAll();

        return $this->render('crud/units/list.html.twig', [
            'units' => $units
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

            return $this->redirectToRoute('list_units');
        }
        return $this->render('crud/units/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/units/edit/{name}", name="unit_edit")
     */
    public function editAction(Request $request, Unit $unit){
        $form = $this->createForm(AddUnitForm::class, $unit);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $unit = $form->getData();

            $em->persist($unit);
            $em->flush();

            return $this->redirectToRoute('list_units');
        }
        return $this->render('crud/units/edit.html.twig', [
            'form' => $form->createView(),
            'unit' => $unit
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/units/delete/{id}", name="unit_delete")
     *
     */
    public function removeUnitAction($id){
        $em = $this->getDoctrine()->getManager();

        $unit = $em->getRepository('AppBundle:Unit')->find($id);
        $em->remove($unit);
        $em->flush();
        return $this->redirectToRoute('list_units');
    }

    /**
     * @Route("crud/units/{name}", name="show_unit")
     */
    public function showAction(Unit $unit){
        return $this->render('crud/units/show.html.twig', [
            'unit' => $unit
        ]);
    }
}