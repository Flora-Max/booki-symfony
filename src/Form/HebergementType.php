<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Category;
use App\Entity\Hebergement;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HebergementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\établissement',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du lieu'
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix de la nuit',
            ])
            ->add('postcode', IntegerType::class, [
                'label' => 'Code postal:'
            ])
            ->add('category', TextType::class, [
                'label' => 'Categorie :',
            ])
            ->add('city', TextType::class, [
                'label' => 'Situation géographique - Ville:',
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
            'data_class' => Hebergement::class,
        ]);
    }
}
