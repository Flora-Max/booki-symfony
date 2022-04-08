<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'activité:"
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description de l'activité:"
            ])
            ->add('postcode', IntegerType::class, [
                'label' => 'Code postal:'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville: ',
            ])
            ->add('image_large', FileType::class, [
                'label' => "Photos L"
            ])
            ->add('image_medium', FileType::class, [
                'label' => "Photos M"
            ])
            ->add('image_small', FileType::class, [
                'label' => "Photos S"
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Générer'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
