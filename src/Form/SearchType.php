<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Race;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('race', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Race::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('habitat', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    'Savanne' => 'HABITAT_SAVANNAH',
                    'Jungle' => 'HABITAT_JUNGLE',
                    'Marais' => 'HABITAT_SWAMP',
                    // Ajoutez d'autres habitats selon vos besoins
                ],
                'expanded' => true,
                'multiple' => true
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
