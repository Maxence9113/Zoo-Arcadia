<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Race;
use App\Repository\RaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('race', EntityType::class, [
                'class' => Race::class,
                'choice_label' => 'name',
                'query_builder' => function (RaceRepository $raceRepository) {
                    return $raceRepository->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
            ])
            // ->add('pictureAnimal', FileType::class, [
            //     'label' => 'Image (jpeg, webp)',
            //     'mapped' => false,
            //     'multiple' => true,
            //     'required' => false,
            //     'constraints' => [
            //         new File([
            //             // 'maxSize' => '1024k',
            //             'mimeTypes' => [
            //                 'image/jpeg',
            //                 'image/webp',
            //             ],
            //             'mimeTypesMessage' => 'Please upload a valid image file',
            //         ])
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
