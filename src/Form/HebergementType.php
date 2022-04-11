<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Category;
use App\Entity\Hebergement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\File\File;

class HebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\établissement',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du lieu',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix de la nuit',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('postcode', IntegerType::class, [
                'label' => 'Code postal:',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('category', TextType::class, [
                'label' => 'Categorie :',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Situation géographique - Ville:',
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            /*->add('image_large', FileType::class, [
                'label' => "Photos L"
            ])
            ->add('image_medium', FileType::class, [
                'label' => "Photos M"
            ])
            ->add('image_small', FileType::class, [
                'label' => "Photos S"
            ])*/
            ->add('submit', SubmitType::class, [
                'label' => 'Générer',
                'attr' => [
                    'class' => "btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hebergement::class,
        ]);
    }
}
