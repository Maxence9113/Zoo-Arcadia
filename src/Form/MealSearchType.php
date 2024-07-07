<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Animal;
use App\Entity\Race;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealSearchType extends AbstractType
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
            ->add('employee', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => User::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('race', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Race::class,
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC'); // Assurez-vous que 'name' est le champ par lequel vous souhaitez trier
    },
            ])
            ->add('habitat', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    'Marais' => 'HABITAT_SWAMP',
                    'Jungle' => 'HABITAT_JUNGLE',
                    'Savanne' => 'HABITAT_SAVANNAH',
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
