<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Meal;
use App\Entity\User;
use App\Entity\VeterinaryReport;
use Doctrine\ORM\EntityRepository;
use IntlDateFormatter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeterinaryReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'Europe/Paris',
            IntlDateFormatter::GREGORIAN,
            'EE dd MMMM yyyy'
        );

        $builder
            ->add('comment')
            // ->add('createdAt', null, [
            //     'widget' => 'single_text'
            // ])
            ->add('employee', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'data' => $user,
                'disabled' => true,
            ])
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'name',
            ])
            ->add('meal', EntityType::class, [
                'class' => Meal::class,
                'choice_label' => 'id',
            ])
            ->add('meal', EntityType::class, [
                'class' => Meal::class,
                'choice_label' => function (Meal $meal) use ($formatter) {
                    // Formattez la date comme vous le souhaitez
                    $formattedDate = $formatter->format($meal->getDate());
                    // Retournez la chaîne de caractères qui combine le nom de l'animal et la date de création
                    return $formattedDate . ' - ' . $meal->getAnimal()->getName();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.date', 'DESC'); // 'm.date' est le nom de la propriété de date dans l'entité Meal, 'ASC' pour un ordre croissant
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VeterinaryReport::class,
            'user' => null

        ]);
    }
}
