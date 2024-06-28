<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PassewordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Votre mot de passe actuel:',
                'attr' => [
                    'placeholder' => 'Entrez votre de passe actuel'
                ],
                'mapped' => false,

            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Entrez votre mot de passe:', 
                    'hash_property_path' => 'password',
                    'attr' => [
                        'placeholder' => 'Entrez votre mot de passe',
                    ],
                    // 'constraints' => [new Length(['min' => 3])],
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe:',
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe',
                    ],
                ],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Mettre a jour le mot de passe',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])

            // Ecouter actualPassword afin de pouvoir le comparer a la BDD
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];
                $actualPwd = $form->get('actualPassword')->getData();
                
                // 1 Récupérer le mot de passe saisi et le comparé
                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $actualPwd
                );

                // 2. Si c'est isValid est false envoyer une erreur
                if (!$isValid) {
                    $form->get('actualPassword')->addError(new FormError('Mot de passe actuel non conforme'));
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null
        ]);
    }
}
