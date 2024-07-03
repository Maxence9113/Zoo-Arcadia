<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\PictureAnimal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class PictureAnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('picture_animal', FileType::class, [
                'label' => 'Image (jpeg, webp)',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                // 'maxSize' => '1024k',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/webp',
                                ],
                                'mimeTypesMessage' => 'Please upload a valid image file',
                            ])
                        ]
                    ])
                ],
            ])
            ->add('descriptionAlt')
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
            ])
            ->add('Editer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PictureAnimal::class,
        ]);
    }
}
