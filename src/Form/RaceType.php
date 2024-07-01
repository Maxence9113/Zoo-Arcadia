<?php

namespace App\Form;

use App\Entity\Race;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                // 'attr' => [
                //     'placeholder' => 'Doe',
                // ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                // 'attr' => [
                //     'placeholder' => 'Doe',
                // ]
            ])
            ->add(
                'habitat',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Savane' => 'HABITAT_SAVANNAH',
                        'Jungle' => 'HABITAT_JUNGLE',
                        'Marais' => 'HABITAT_SWAMP',
                    ],
                    'multiple' => false,
                    'label' => 'Habitat',
                ]
            )

            ->add('illustration', FileType::class, [
                'label' => 'Illustration (jpeg, webp)',
                'mapped' => false,
                'required'=> false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier valide',
                    ])
                ]
            ])
            ->add('illustrationAlt', TextType::class, [
                'label' => 'Balise Alt',
                // 'attr' => [
                //     'placeholder' => 'Doe',
                // ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Race::class,
        ]);
    }
}
