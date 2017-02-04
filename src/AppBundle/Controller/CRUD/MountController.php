<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 2/4/17
 * Time: 10:10 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\Mount;
use AppBundle\Form\AddMountForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class MountController extends AbstractCRUDController
{
    /**
     * @Route("/mounts", name="list_mounts")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();

        $mounts = $em->getRepository('AppBundle:Mount')
            ->findAll();

        $attributes = $this->serialize($mounts[0]);
        unset($attributes['id']);
        unset($attributes['description']);

        $mountsArray = array();

        foreach($mounts as $mount){
            $mountsArray[] = $this->serialize($mount);
        }

        return $this->render('crud/mounts/list.html.twig', [
            'entities' => $mountsArray,
            'routes'   => $this->routes,
            'entityName' => $this->entityName,
            'attributes' => $attributes
        ]);
    }

    /**
     * @Route("crud/mounts/{name}", name="show_mount")
     */
    public function showAction(Mount $mount){
        $attributes = $this->serialize($mount);
        return $this->render('crud/mounts/show.html.twig', [
            'entity' => $mount,
            'attributes' => $attributes,
            'routes' => $this->routes
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/mounts_add", name="add_mounts")
     */
    public function addAction(Request $request){
        $form = $this->createForm(AddMountForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){

            $mount = $form->getData();

            $em->persist($mount);
            $em->flush();

            $redirectRoute = $form->get('saveAndAdd')->isClicked() ? 'add_mounts':'list_mounts';

            $this->addFlash('success', sprintf('%s successfully created!', $mount->getName()));

            return $this->redirectToRoute($redirectRoute);
        }
        return $this->render('crud/mounts/new.html.twig', [
            'form' => $form->createView(),
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/mounts/edit/{name}", name="edit_mount")
     */
    public function editAction(Request $request, Mount $mount){
        $form = $this->createForm(AddMountForm::class, $mount);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $mount = $form->getData();

            $em->persist($mount);
            $em->flush();

            $this->addFlash('success', sprintf('%s successfully updated!', $mount->getName()));

            return $this->redirectToRoute('list_mounts');
        }
        return $this->render('crud/mounts/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $mount,
            'routes' => $this->routes,
            'twigForm' => $this->twigForm,
            'entityName' => $this->entityName
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/crud/mounts/delete/{id}", name="delete_mount")
     *
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();

        $mount = $em->getRepository('AppBundle:Mount')->find($id);
        $em->remove($mount);
        $em->flush();
        return $this->redirectToRoute('list_mounts');
    }


    function setRoutes()
    {
        $this->routes = [
            'edit'   => 'edit_mount',
            'list'   => 'list_mounts',
            'new'    => 'add_mounts',
            'show'   => 'show_mount',
            'delete' => 'delete_mount'
        ];

        $this->twigForm = 'crud/mounts/_mountsForm.html.twig';
        $this->entityName = 'Mount';
    }

    function serialize(Mount $mount){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($mount);
        return $attributes;
    }
}