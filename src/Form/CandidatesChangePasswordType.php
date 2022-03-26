<?php

namespace App\Form;

use App\Entity\Candidates;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CandidatesChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon email',
                'attr' => [
                    'class' => "form-control m-2"]
            ])

            ->add('old_password', PasswordType::class, [
                'label' => "Mon mot de passe actuel",
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Entrez votre mot de passe actuel',
                    'class' => "form-control m-2"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'constraints' => new Length([
                    'min' => 8,]),
                'invalid_message' => 'Le nouveau mot de passe et sa confirmation doivent être identiques',
                'label' => "Votre nouveau mot de passe",
                'required' => true,
                'first_options' => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Merci de saisir votre nouveau mot de passe",
                        'class' => "form-control m-2"
                    ]],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => "Merci de confirmer votre nouveau mot de passe",
                        'class' => "form-control m-2"
                    ]]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    'class' => "btn btn-lg btn-primary m-3"
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidates::class,
        ]);
    }
}
