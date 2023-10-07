<?php

namespace App\Form;

use App\Entity\Master;
use App\Entity\Membres;
use App\Entity\ProjetRecherche;
use App\Entity\Stagiaire;
use App\Entity\SujetRecherche;
use Proxies\__CG__\App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;

class SujetRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    'class'=>'form-control mt-2',
                    'placeholder'=>'Name',
                    'required'
                ]

            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'attr' => [
                    'class'=>'form-control mt-4',
                    'placeholder'=>' description',
                    'rows'=>'5'
                ]
            ])
            ->add('pfe', CheckboxType::class, [

            ])
            ->add('datedebut',DateType::class,[
                'label' => 'date Debut',
                'attr' => [
                    'class'=>'mt-4'
                ]
            ])
            ->add('datefine',DateType::class,[
                'label' => 'date Fin',
                'attr' => [
                    'class'=>'mt-4'
                ]
            ])
            ->add('Encadren',EntityType::class,[
                'label' => 'Encadrent',
                'expanded'=>false,
                'required'=>false,
                'class'=>Professeur::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ] )

            ->add('master',EntityType::class,[
                'expanded'=>false,
                'required'=>false,
                'class'=>Master::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ] )
            ->add('Stagiaire',EntityType::class,[
                'expanded'=>false,
                'required'=>false,
                'class'=>Stagiaire::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ] )
            ->add('PrAssocie',EntityType::class,[
                'class'=>ProjetRecherche::class,
                'label' => 'Projet de Recherche associe',
            ])
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
                        'maxSize' => '3072k',
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
            'data_class' => SujetRecherche::class,
        ]);
    }
}
