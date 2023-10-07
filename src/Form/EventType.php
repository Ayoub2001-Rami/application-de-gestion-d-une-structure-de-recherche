<?php

namespace App\Form;

use App\Entity\EVENEMENT;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    'class'=>'form-control mt-4',
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr' => [
                    'class'=>'form-control mt-4'
                ]
            ])
            ->add('type', TextType::class,[
                'attr' => [
                    'class'=>'form-control mt-4',
                ]
            ])
            ->add('date',DateType::class,[
                'attr' => [

                ]
            ])

            ->add('lieu', TextType::class,[
                'attr' => [
                    'class'=>'mt-4 form-control',
                ]
            ])

            ->add('image',FileType::class,[
                'label' => 'image',
                'mapped' =>false,
                'required'=> false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                    ])
                ]
                ,
                'attr' => [
                    'class'=>'form-control mt-4',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EVENEMENT::class,
        ]);
    }
}
