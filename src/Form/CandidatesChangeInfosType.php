<?php

namespace App\Form;

use App\Entity\Candidates;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CandidatesChangeInfosType extends AbstractType
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
            ->add('firstname', TextType::class, [
                'label' => 'Mon prénom',
                'attr' => [
                    'class' => "form-control m-2",
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Mon nom',
                'attr' => [
                    'class' => "form-control m-2",
                ]
            ])
            ->add('CvFilename', FileType::class, [
                'label' => 'Votre CV en format PDF (Max 1Mo)',
                'required' => false,
                'attr' => [
                    'class' => "form-control m-2",
                ],
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Merci de transmettre un fichier au format PDF uniquement',
                    ])
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    'class' => "btn btn-warning m-2",
                ]

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidates::class,
        ]);
    }
}
