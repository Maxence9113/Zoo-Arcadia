<?php

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentSearchType extends AbstractType
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
      ->add('isApprouved', ChoiceType::class, [
        'label' => false,
        'required' => false,
        'choices' => [
          'Oui' => true,
          'Non' => false,
        ],
        'expanded' => true,
        'multiple' => true
      ])
      ->add('note', ChoiceType::class, [
        'label' => false,
        'required' => false,
        'choices' => [
          '1' => 1,
          '2' => 2,
          '3' => 3,
          '4' => 4,
          '5' => 5,
        ],
        'expanded' => true,
        'multiple' => true
      ]);
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
