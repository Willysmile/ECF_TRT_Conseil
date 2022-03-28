<?php

namespace App\Form;

use App\Entity\JobAds;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class JobAdsAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé du poste',
                'attr' => [
                    'placeholder' => "Merci de saisir l’intitulé du poste",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]
            ])
            ->add('description', TextareaType::class, ['label' => 'Description du poste',
                'attr' => [
                    'placeholder' => "Merci de saisir la description du poste",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse', 'attr' => [
                    'placeholder' => "Merci de saisir l'adresse",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]
            ])


            ->add('zipcode', TextType::class, [
                'label' => 'Code Postal',
                'constraints' => new Length(
                    5),
                'attr' => [
                    'placeholder' => "Merci de saisir le code postal",
                    'class' => "form-control m-2",
                    'style' => "width : 50%"
                ]
            ])




            ->add('submit', SubmitType::class, [
                'label' => "Envoyer l’annonce",
                'attr' => [
                    'class' => "btn btn-lg btn-primary m-3"
                ]]);



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobAds::class,
        ]);
    }
}
