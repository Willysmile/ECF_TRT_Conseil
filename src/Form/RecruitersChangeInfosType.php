<?php

namespace App\Form;

use App\Entity\Recruiters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RecruitersChangeInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon email',
                'attr' => [
                    'class' => "form-control m-2",
                ]
            ])
            ->add('society_name', TextType::class, [
                'label' => 'Nom de la société',
                'attr' => [
                    'class' => "form-control m-2",
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'class' => "form-control m-2",
                ]
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Votre code postal',
                'constraints' => new Length(5
                ),
                'attr' => [
                    'class' => "form-control m-2",
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    'class' => "btn btn-warning m-2",
                ]

            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recruiters::class,
        ]);
    }
}
