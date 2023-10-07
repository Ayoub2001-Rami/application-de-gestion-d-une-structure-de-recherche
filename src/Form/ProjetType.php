<?php

namespace App\Form;

use App\Entity\Membres;
use App\Entity\Professeur;
use App\Entity\ProjetRecherche;
use App\Entity\SujetRecherche;
use App\Entity\SujetThese;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\File;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('financement')
            ->add('dateDebut')
            ->add('Datefin', \Symfony\Component\Form\Extension\Core\Type\DateType::class,[
                'label' => 'date Fin',
                'attr' => [
                    'class'=>'mt-4'
                ]
            ])
            ->add('coordinateurPrinc' ,EntityType::class,[
                'label' => 'Coordinateur Principale',
                'expanded'=>false,
                'required'=>false,
                'class'=>Professeur::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ])
            ->add('sujetThese',EntityType::class,[
                'label' => 'Sujet de These',
                'expanded'=>false,
                'required'=>false,
                'class'=>SujetThese::class,
                'choice_label'=>'titre',
                'attr' => [
                    'class'=>'select2',
                ],
            ])
            ->add('sujetRecherche',EntityType::class,[
                    'label' => 'Sujet de Recherche',
                'expanded'=>false,
                'required'=>false,
                'class'=>SujetRecherche::class,
                'choice_label'=>'titre',
                'attr' => [
                        'class'=>'select2',
                    ],
                ]
            )
            ->add('Membres',EntityType::class,[
                'label' => 'Les Membres',
                'expanded'=>false,
                'required'=>false,
                'class'=>Membres::class,
                'multiple'=>true,
                'attr' => [
                    'class'=>'select2',
                ],
            ] )
            ->add('PDF', FileType::class, [
                'label' => 'PDF document',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'PDF document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjetRecherche::class,
        ]);
    }
}
