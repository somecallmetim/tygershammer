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
    public function listAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        //TODO can we get rid of either $units or $unitsArray and use just one in the twig template?

        // $units eventually ends up being an associative array where the unit name is the key and the data in each
        // entry is another array that contains all that unit's data
        $units = $em->getRepository('AppBundle:Unit')
            ->findAll();

        // $attributes is an associative array that is only being used for it's keys, which are the data fields
        // for the unit entity
        $attributes = $this->serialize($units[0]);

        // $unitsArray eventually ends up being an array where each entry is the data of a given unit in the database.
        $unitsArray = array();
        $showFaction = false;
        $factionChosen = false;

        $this->serializeUnits($units, $unitsArray, $attributes);

        return $this->render('crud/units/list.html.twig', [
            // array
            'entities' => $unitsArray,
            // array of routes the template needs
            'routes'   => $this->routes,
            // string name for the entity this controller/twig template addresses
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

        // $units eventually ends up being an associative array where the unit name is the key and the data in each
        // entry is another array that contains all that unit's data
        $units = $em->getRepository('AppBundle:Unit')->findBySearchTerm((string)$searchTerms);


        // when search yields results
        if(!empty($units)){
            $attributes = $this->serialize($units[0]);
            $unitsArray = array();
            $showFaction = false;
            $factionChosen = false;

            $this->serializeUnits($units, $unitsArray, $attributes);

            return $this->render('crud/units/list.html.twig', [
                // array
                'entities' => $unitsArray,
                // array of routes the template needs
                'routes'   => $this->routes,
                // string name for the entity this controller/twig template addresses
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
            $units = $em->getRepository('AppBundle:Unit')
                ->findAll();

            $attributes = $this->serialize($units[0]);
            $unitsArray = array();
            $showFaction = false;
            $factionChosen = false;

            $this->serializeUnits($units, $unitsArray, $attributes);

            return $this->render('crud/units/list.html.twig', [
                // array
                'entities' => $unitsArray,
                // array of routes the template needs
                'routes'   => $this->routes,
                // string name for the entity this controller/twig template addresses
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

        $units = $em->getRepository('AppBundle:Unit')->findByAlliance($alliance);

        $allianceEntity = $em->getRepository('AppBundle:Alliance')
            ->findBy([
               'name' => $alliance
            ]);

        $factions = $em->getRepository('AppBundle:Faction')
            ->findBy([
                'alliance' => $allianceEntity
            ]);

        $attributes = $this->serialize($units[0]);
        $unitsArray = array();
        $showFaction = true;
        $factionChosen = false;

        $this->serializeUnits($units, $unitsArray, $attributes);

        return $this->render('crud/units/list.html.twig', [
            // array
            'entities' => $unitsArray,
            // array of routes the template needs
            'routes'   => $this->routes,
            // string name for the entity this controller/twig template addresses
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

        $factionEntity = $em->getRepository('AppBundle:Faction')
            ->findBy([
                'name' => $faction
            ]);

        $units = $em->getRepository('AppBundle:Unit')
            ->findBy([
                'faction' => $factionEntity
            ]);

        $allianceEntity = $em->getRepository('AppBundle:Alliance')
            ->findBy([
                'name' => $alliance
            ]);

        $factions = $em->getRepository('AppBundle:Faction')
            ->findBy([
                'alliance' => $allianceEntity
            ]);

        $attributes = $this->serialize($units[0]);
        $unitsArray = array();
        $showFaction = true;
        $factionChosen = true;

        $this->serializeUnits($units, $unitsArray, $attributes);

        return $this->render('crud/units/list.html.twig', [
            // array
            'entities' => $unitsArray,
            // array of routes the template needs
            'routes'   => $this->routes,
            // string name for the entity this controller/twig template addresses
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
        $attributes = $this->serialize($unit);

        $weaponsList = "";
        $weaponsArray = $attributes['weapons'];
        $numOfWeapons = count($weaponsArray);
        $count = 0;

        foreach($weaponsArray as $weapon){
            if($count < $numOfWeapons){
                $weaponsList = $weaponsList . $weapon . ", ";
            }else {
                $weaponsList = $weaponsList . $weapon;
            }
            $count = $count + 1;
        }

        $attributes['weapons'] = $weaponsList;

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

    private function serializeUnits(&$units, &$unitsArray, &$attributes){
        unset($attributes['id']);
        unset($attributes['description']);

        foreach($units as $unit){
            $unitsArray[] = $this->serialize($unit);
        }
    }

    function serialize(Unit $unit){
        $serializer = $this->get('app.entity_serializer');
        $attributes = $serializer->buildAttributeArray($unit);
        $faction = $attributes['faction'];
        $alliance = $attributes['alliance'];
        $attributes['faction'] = $faction['name'];
        $attributes['alliance'] = $alliance['name'];
        return $attributes;
    }
}