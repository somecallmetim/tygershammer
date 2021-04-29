<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/4/17
 * Time: 12:34 PM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\Alliance;
use AppBundle\Form\AddAllianceForm;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class AllianceController extends AbstractCRUDController
{
    /**
     * @Route("/alliances", name="list_alliances")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $alliances = $em->getRepository('AppBundle:Alliance')
            ->findAll();

        $attributes = $this->serialize($alliances[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $alliancesArray = array();

        foreach($alliances as $alliance){
            $alliancesArray[] = $this->serialize($alliance);
        }

        return $this->render('crud/alliances/list.html.twig', [
            'entities' => $alliancesArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/alliances/{name}", name="show_alliance")
     */
    public function showAction(Alliance $alliance){
        $attributes = $this->serialize($alliance);
        return $this->render('crud/alliances/show.html.twig', [
            'entity' => $alliance,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/alliances_add", name="add_alliances")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddAllianceForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $alliance = $form->getData();

            $em->persist($alliance);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_alliances':'list_alliances';

            $this->addFlash('success', sprintf('%s successfully created!', $alliance->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/alliances/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/alliances/edit/{name}", name="edit_alliance")
     */
    public function editAction(Request $request, Alliance $alliance){
        $form = $this->createForm(AddAllianceForm::class, $alliance);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $alliance = $form->getData();

            $em->persist($alliance);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $alliance->getName()));

            return $this->redirectToRoute('list_alliances');
        }
        return $this->render('crud/alliances/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $alliance,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/alliances/delete/{id}", name="delete_alliance")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $alliance = $em->getRepository('AppBundle:Alliance')->find($id);
        $em->remove($alliance);
        $em->flush();
        return $this->redirectToRoute('list_alliances');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_alliance',
            'list'   => 'list_alliances',
            'new'    => 'add_alliances',
            'show'   => 'show_alliance',
            'delete' => 'delete_alliance'
        ];

        $this->twigForm = 'crud/alliances/_alliancesForm.html.twig';
        $this->entityName = 'Alliance';
    }

    function serialize(Alliance $alliance){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($alliance);
        return $attributes;
    }
}