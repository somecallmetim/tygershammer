<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/17/16
 * Time: 12:55 AM
 */

namespace AppBundle\Controller\CRUD;


use AppBundle\Controller\AbstractCRUDController;
use AppBundle\Entity\Alliance;
use AppBundle\Entity\Unit;
use AppBundle\Form\AddUnitForm;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class AoSUnitsController extends AbstractCRUDController
{
    /**
     * @Route("/units", name="list_units")
     */
    public function listAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        // gives us an array of 'unit' entity objects
        $units = $em->getRepository('AppBundle:Unit')
            ->findAll();

        // this extracts the field names from unit entity object
        $attributes = $units[0]->getAllDataAsAssociativeArray();
        $attributes = array_keys($attributes);

        // tells template what dropdown menus it needs to display
        $showFaction = false;
        $factionChosen = false;

        return $this->render('crud/units/list.html.twig', [
            // this is the array that contains all our actual units for our table
            'entities' => $units,
            // array of routes the template needs
            'routes'   => $this->routes,
            // used to dynamically name buttons/elements in twig templates
            'entityName' => $this->entityName,
            // array that holds the attributes of the entity this controller/twig template addresses
            'attributes' => $attributes,
            // boolean
            'showFaction' => $showFaction,
            // boolean
            'factionChosen' =>$factionChosen
        ]);
    }

    /**
     * @Route("/units/search_results/{searchTerms}", options={"expose"=true},name="listSearchResults")
     */
    public function listSearchResultsAction($searchTerms){
        $em = $this->getDoctrine()->getManager();

        // gives us an array of 'unit' entity objects
        $units = $em->getRepository('AppBundle:Unit')->findBySearchTerm((string)$searchTerms);


        // when search yields non-zero results
        if(!empty($units)){
            // this extracts the field names from unit entity
            $attributes = $units[0]->getAllDataAsAssociativeArray();
            $attributes = array_keys($attributes);

            // tells template what dropdown menus it needs to display
            $showFaction = false;
            $factionChosen = false;


            return $this->render('crud/units/list.html.twig', [
                // this is the array that contains all our actual units for our table
                'entities' => $units,
                // array of routes the template needs
                'routes'   => $this->routes,
                // used to dynamically name buttons/elements in twig templates
                'entityName' => $this->entityName,
                // array that holds the attributes of the entity this controller/twig template addresses
                'attributes' => $attributes,
                // boolean
                'showFaction' => $showFaction,
                // boolean
                'factionChosen' =>$factionChosen
            ]);

        // when search doesn't yield results
        }else {
            $this->addFlash('danger', sprintf('No results found. :('));

            // gives us an array of 'unit' entity objects
            $units = $em->getRepository('AppBundle:Unit')
                ->findAll();

            // this extracts the field names from unit entity
            $attributes = $units[0]->getAllDataAsAssociativeArray();
            $attributes = array_keys($attributes);

            // tells template what dropdown menus it needs to display
            $showFaction = false;
            $factionChosen = false;


            return $this->render('crud/units/list.html.twig', [
                // this is the array that contains all our actual units for our table
                'entities' => $units,
                // array of routes the template needs
                'routes'   => $this->routes,
                // used to dynamically name buttons/elements in twig templates
                'entityName' => $this->entityName,
                // array that holds the attributes of the entity this controller/twig template addresses
                'attributes' => $attributes,
                // boolean
                'showFaction' => $showFaction,
                // boolean
                'factionChosen' =>$factionChosen
            ]);
        }


    }

    /**
     * @Route("/units/{alliance}", name="list_units_by_alliance_alone")
     */
    public function listByAllianceAction($alliance){
        $em = $this->getDoctrine()->getManager();

        // gives us an array of 'unit' entity objects
        $units = $em->getRepository('AppBundle:Unit')->findByAlliance($alliance);

        // gives us singular 'alliance' entity object
        $allianceEntity = $em->getRepository('AppBundle:Alliance')
            ->findBy([
               'name' => $alliance
            ]);

        // gives us an array of 'faction' entity objects
        $factions = $em->getRepository('AppBundle:Faction')
            ->findBy([
                'alliance' => $allianceEntity
            ]);

        // this extracts the field names from unit entity
        $attributes = $units[0]->getAllDataAsAssociativeArray();
        $attributes = array_keys($attributes);

        // tells template what dropdown menus it needs to display
        $showFaction = true;
        $factionChosen = false;


        return $this->render('crud/units/list.html.twig', [
            // this is the array that contains all our actual units for our table
            'entities' => $units,
            // array of routes the template needs
            'routes'   => $this->routes,
            // used to dynamically name buttons/elements in twig templates
            'entityName' => $this->entityName,
            // array that holds the attributes of the entity this controller/twig template addresses
            'attributes' => $attributes,
            // boolean
            'showFaction' => $showFaction,
            // boolean
            'factionChosen' =>$factionChosen,
            // string
            'alliance' => $alliance,
            // string
            'factions' => $factions
        ]);
    }

    /**
     * @Route("/units/{alliance}/{faction}", name="list_units_by_faction_and_alliance")
     */
    public function listByFactionAction($alliance, $faction){
        $em = $this->getDoctrine()->getManager();

        // gives us a singular 'faction' entity object
        $factionEntity = $em->getRepository('AppBundle:Faction')
            ->findBy([
                'name' => $faction
            ]);

        // gives us an array of 'unit' entity objects
        $units = $em->getRepository('AppBundle:Unit')
            ->findBy([
                'faction' => $factionEntity
            ]);

        // gives us a singular 'alliance' entity object
        $allianceEntity = $em->getRepository('AppBundle:Alliance')
            ->findBy([
                'name' => $alliance
            ]);

        // gives us an array of 'faction' entity objects
        $factions = $em->getRepository('AppBundle:Faction')
            ->findBy([
                'alliance' => $allianceEntity
            ]);

        // this extracts the field names from unit entity
        $attributes = $units[0]->getAllDataAsAssociativeArray();
        $attributes = array_keys($attributes);

        // tells template what dropdown menus it needs to display
        $showFaction = true;
        $factionChosen = true;


        return $this->render('crud/units/list.html.twig', [
            // this is the array that contains all our actual units for our table
            'entities' => $units,
            // array of routes the template needs
            'routes'   => $this->routes,
            // used to dynamically name buttons/elements in twig templates
            'entityName' => $this->entityName,
            // array that holds the attributes of the entity this controller/twig template addresses
            'attributes' => $attributes,
            // boolean
            'showFaction' => $showFaction,
            // boolean
            'factionChosen' =>$factionChosen,
            // string
            'alliance' => $alliance,
            // string
            'currentFaction' => $faction,
            // array
            'factions' => $factions
        ]);
    }

    /**
     * @Route("crud/units/{name}", name="show_unit")
     */
    public function showAction(Unit $unit){

        // this extracts the field names from unit entity
        $attributes = $unit->getAllDataAsAssociativeArray();
        $attributes = array_keys($attributes);

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

}