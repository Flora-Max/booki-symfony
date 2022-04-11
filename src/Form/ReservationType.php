<?php

namespace App\Form;

use App\Entity\Hebergement;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hebergement', EntityType::class, [
                'label' => "Hebergement",
                'class' => Hebergement::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('quantityNight', IntegerType::class, [
                'label' => 'Nombre de nuits:',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('quantityPeople', IntegerType::class, [
                'label' => 'Nombre de personne:',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('creationDate', DateType::class, [
                'label' => ' Date de création de votre réservation: ',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('firstNightDate', DateType::class, [
                'label' => 'Début de votre séjour: ',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider: ',
                'attr' => [
                    'class' => "btn-primary"
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
