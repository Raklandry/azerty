<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "label" =>false,
                'invalid_message' => 'Verifiez votre nom!',
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" =>false,
                'invalid_message' => 'Verifiez votre adresse e-mail!',
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add('Tel', NumberType::class, [
                "label" =>false,
                'invalid_message' => 'Verifiez votre numero téléphone!',
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add('Adresse', TextType::class, [
                "label" =>false,
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add('Cin', TextType::class, [
                "label" =>false,
                'invalid_message' => 'Verifiez votre CIN !',
                "attr" => [
                    "class" => "input"
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                "label" =>false,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'le mot de passe est incorrect !',
                'options' => ['attr' => ['class' => 'input password-field']],
                'required' => true,
                'first_options' => ['label' => false],
                'second_options' => ['label' => false],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez-votre mot de passe !',
                    ]),

                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être plus de {{ limit }} caractères !',
                        'max' => 4096,  
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
