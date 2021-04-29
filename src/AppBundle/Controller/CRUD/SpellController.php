<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/4/17
 * Time: 11:30 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\Spell;
use AppBundle\Form\AddSpellForm;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class SpellController extends AbstractCRUDController
{
    /**
     * @Route("/spells", name="list_spells")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $spells = $em->getRepository('AppBundle:Spell')
            ->findAll();

        $attributes = $this->serialize($spells[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $spellsArray = array();

        foreach($spells as $spell){
            $spellsArray[] = $this->serialize($spell);
        }

        return $this->render('crud/spells/list.html.twig', [
            'entities' => $spellsArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/spells/{name}", name="show_spell")
     */
    public function showAction(Spell $spell){
        $attributes = $this->serialize($spell);
        return $this->render('crud/spells/show.html.twig', [
            'entity' => $spell,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/spells_add", name="add_spells")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddSpellForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $spell = $form->getData();

            $em->persist($spell);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_spells':'list_spells';

            $this->addFlash('success', sprintf('%s successfully created!', $spell->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/spells/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/spells/edit/{name}", name="edit_spell")
     */
    public function editAction(Request $request, Spell $spell){
        $form = $this->createForm(AddSpellForm::class, $spell);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $spell = $form->getData();

            $em->persist($spell);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $spell->getName()));

            return $this->redirectToRoute('list_spells');
        }
        return $this->render('crud/spells/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $spell,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/spells/delete/{id}", name="delete_spell")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $spell = $em->getRepository('AppBundle:Spell')->find($id);
        $em->remove($spell);
        $em->flush();
        return $this->redirectToRoute('list_spells');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_spell',
            'list'   => 'list_spells',
            'new'    => 'add_spells',
            'show'   => 'show_spell',
            'delete' => 'delete_spell'
        ];

        $this->twigForm = 'crud/spells/_spellsForm.html.twig';
        $this->entityName = 'Spell';
    }

    function serialize(Spell $spell){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($spell);
        return $attributes;
    }
}