<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Meal;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('quantity')
            ->add('createdAt', DateType::class, [])
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
            ])
            ->add('employee', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'data' => $user,
                'disabled' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
            'user' => null
        ]);
    }
}
