<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Category;
use App\Entity\Hebergement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('category', EntityType::class, [
                'label' => 'Categorie :',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('city', EntityType::class, [
                'label' => 'Situation géographique - Ville:',
                'class' => City::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
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
