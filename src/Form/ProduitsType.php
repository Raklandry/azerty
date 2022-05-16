<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Produits;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                "label" =>false,
                'invalid_message' => 'Verifiez le nom de votre produit!',
                "attr" => [
                    "class" => "input form-control"
                ]
            ])
            ->add('description', TextareaType::class,[
                "label" =>false,
                'invalid_message' => 'Verifiez le déscription de votre produit!',
                "attr" => [
                    "class" => "input form-control"
                ]
            ])
            ->add('prix', NumberType::class,[
                "label" =>false,
                'invalid_message' => 'Verifiez le prix de votre produit!',
                "attr" => [
                    "class" => "input form-control"
                ]
            ])
            ->add('promo', CheckboxType::class,[
                "label" =>false,
                "required" => false,
            ])

            ->add('categories', EntityType::class, [
                "class" => Categories::class,
                "choice_label" => "nom"
            ])
            ->add('ProduitImage', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
