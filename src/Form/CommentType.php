<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('comment')
            ->add('note', ChoiceType::class, [
                'choices'  => [
                    'Excellent' => 5,
                    'Très bien' => 4,
                    'Satisfaisant' => 3,
                    'Passable' => 2,
                    'Médiocre' => 1,
                ],
                'multiple' => false,
                'label' => 'Note',

            ]);
        if ($this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $builder->add('isApprouved');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
