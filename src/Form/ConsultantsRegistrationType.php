<?php

namespace App\Form;

use App\Entity\Consultants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ConsultantsRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Votre email",
                'constraints' => new Length([
                    'min' => 5,
                    'max' => 60]),
                'attr' => [
                    'placeholder' => "Merci de saisir l'email du consultant",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'attr' => [
                    'placeholder' => "Merci de saisir le prénom du consultant",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Merci de saisir le nom du consultant",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques',
                'label' => "Votre mot de passe",
                'required' => true,
                'constraints' => new Length([
                    'min' => 8,
                ]),
                'first_options' => ['label' => 'Mot de passe', 'attr' => [
                    'placeholder' => "Merci de saisir votre mot de passe",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]],
                'second_options' => ['label' => 'Confirmation du mot de passe', 'attr' => [
                    'placeholder' => "Merci de confirmer votre mot de passe",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Inscrire le consultant",
                'attr' => [
                    'class' => "btn btn-lg btn-primary m-3"
                ]

            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultants::class,
        ]);
    }
}
