<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/4/17
 * Time: 10:42 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Form\AddPitchedBattleRuleForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\PitchedBattleRule;
use Symfony\Component\HttpFoundation\Request;

class PitchedBattleRuleController extends AbstractCRUDController
{
    /**
     * @Route("/pitchedBattleRules", name="list_pitchedBattleRules")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $pitchedBattleRules = $em->getRepository('AppBundle:PitchedBattleRule')
            ->findAll();

        $attributes = $this->serialize($pitchedBattleRules[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $pitchedBattleRulesArray = array();

        foreach($pitchedBattleRules as $pitchedBattleRule){
            $pitchedBattleRulesArray[] = $this->serialize($pitchedBattleRule);
        }

        return $this->render('crud/pitchedBattleRules/list.html.twig', [
            'entities' => $pitchedBattleRulesArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/pitchedBattleRules/{name}", name="show_pitchedBattleRule")
     */
    public function showAction(PitchedBattleRule $pitchedBattleRule){
        $attributes = $this->serialize($pitchedBattleRule);
        return $this->render('crud/pitchedBattleRules/show.html.twig', [
            'entity' => $pitchedBattleRule,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/pitchedBattleRules_add", name="add_pitchedBattleRules")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddPitchedBattleRuleForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $pitchedBattleRule = $form->getData();

            $em->persist($pitchedBattleRule);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_pitchedBattleRules':'list_pitchedBattleRules';

            $this->addFlash('success', sprintf('%s successfully created!', $pitchedBattleRule->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/pitchedBattleRules/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/pitchedBattleRules/edit/{name}", name="edit_pitchedBattleRule")
     */
    public function editAction(Request $request, PitchedBattleRule $pitchedBattleRule){
        $form = $this->createForm(AddPitchedBattleRuleForm::class, $pitchedBattleRule);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $pitchedBattleRule = $form->getData();

            $em->persist($pitchedBattleRule);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $pitchedBattleRule->getName()));

            return $this->redirectToRoute('list_pitchedBattleRules');
        }
        return $this->render('crud/pitchedBattleRules/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $pitchedBattleRule,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/pitchedBattleRules/delete/{id}", name="delete_pitchedBattleRule")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $pitchedBattleRule = $em->getRepository('AppBundle:PitchedBattleRule')->find($id);
        $em->remove($pitchedBattleRule);
        $em->flush();
        return $this->redirectToRoute('list_pitchedBattleRules');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_pitchedBattleRule',
            'list'   => 'list_pitchedBattleRules',
            'new'    => 'add_pitchedBattleRules',
            'show'   => 'show_pitchedBattleRule',
            'delete' => 'delete_pitchedBattleRule'
        ];

        $this->twigForm = 'crud/pitchedBattleRules/_pitchedBattleRulesForm.html.twig';
        $this->entityName = 'PitchedBattleRule';
    }

    function serialize(PitchedBattleRule $pitchedBattleRule){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($pitchedBattleRule);
        return $attributes;
    }
}