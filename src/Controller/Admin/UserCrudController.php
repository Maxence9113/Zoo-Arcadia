<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname')->setLabel('Prénom'),
            TextField::new('lastname')->setLabel('Nom'),
            TextField::new('email')->setLabel('Email'),
            TextField::new('plainPassword')->setLabel('Mot de passe')
                ->setFormType(RepeatedType::class)
                ->setFormTypeOptions([
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Entrez votre mot de passe', 'hash_property_path' => 'password'],
                    'second_options' => ['label' => 'Comfirmez votre mot de passe'],
                    'mapped' => false,
                    ])
                ->onlyOnForms(),
            ChoiceField::new('profil')
                ->setLabel('Rôle')
                ->setChoices([
                    'Vétérinaire' => 'ROLE_VETERINARY',
                    'Employé' => 'ROLE_EMPLOYEE',
                ])
                // ->allowMultipleChoices()
                // ->renderExpanded()
        ];

    }
}
