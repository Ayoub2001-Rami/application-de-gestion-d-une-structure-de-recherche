<?php

namespace App\Form;

use App\Entity\Doctorant;
use App\Entity\Membres;
use App\Entity\Professeur;
use App\Entity\ProjetRecherche;
use App\Entity\SujetThese;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SujetTheseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('annee')
            ->add('bourse',ChoiceType::class,[
                'choices'=>[
                    'Non'=>'non',
                    'Bourse d\'excellence'=>'bourse d\'excellence',
                    'Bourse d\'universite'=>'bourse d\'universite',
                ],
            ])
            ->add('doctorant',EntityType::class,[
                'expanded'=>false,
                'required'=>false,
                'class'=>Doctorant::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ])
            ->add('encadrant')
            ->add('coencadrant',EntityType::class,[
                'label' => 'Co-Encadrant',
                'expanded'=>false,
                'required'=>false,
                'class'=>Professeur::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ])
            ->add('PrAssocie',EntityType::class,[
                'class'=>ProjetRecherche::class,
                'label' => 'Projet de Recherche associe',
            ])
            //->add('submit',SubmitType::class)
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
                            'application/ris',
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
            'data_class' => SujetThese::class,
        ]);
    }
}
