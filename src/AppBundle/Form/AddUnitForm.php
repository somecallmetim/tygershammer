<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/17/16
 * Time: 1:47 AM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Faction;
use AppBundle\Repository\FactionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Unit;

class AddUnitForm extends AbstractType
{
    private $choiceValues = [
        'placeholder' => 'Please Select A Value',
        'choices' => [
            '0' => 0,
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '*' => -1
        ]
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('minNumOfModels')
            ->add('maxNumOfModels')
            ->add('points')
            ->add('saveValue', ChoiceType::class, $this->choiceValues)
            ->add('braveryValue', ChoiceType::class, $this->choiceValues)
            ->add('numOfWounds', ChoiceType::class, $this->choiceValues)
            ->add('spellsPerRound')
            ->add('description', TextareaType::class)
            ->add('faction', EntityType::class, [
                'placeholder' => 'Choose a Faction',
                'class' => Faction::class,
                'query_builder' => function(FactionRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Unit'
        ]);
    }
}