<?php

namespace AppBundle\Form;

use AppBundle\Entity\WeaponsEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddWeaponForm extends AbstractType
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
            ->add('minRange')
            ->add('maxRange')
            ->add('weaponType', ChoiceType::class, [
                'choices' => [
                    'melee' => 'melee',
                    'ranged' => 'ranged'
                ]
            ])
            ->add('attacks', ChoiceType::class, $this->choiceValues)
            ->add('toHit', ChoiceType::class, $this->choiceValues)
            ->add('toWound', ChoiceType::class, $this->choiceValues)
            ->add('dmgDeterminer', ChoiceType::class, [
                'choices' => [
                    'dice' => 'dice',
                    'static value' => 'static'
                ]
            ])
            ->add('maxDieDmgValue', ChoiceType::class, [
                'choices' => [
                    'Please select a value' => null,
                    '3' => 3,
                    '6' => 6
                ]
            ])
            ->add('numberOfDmgDice')
            ->add('staticDmg')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Weapon'
        ]);
    }

}
