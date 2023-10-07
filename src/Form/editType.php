<?php

namespace App\Form;
use App\Entity\Professeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class editType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'placeholder' => 'Nom',
                    'required',

                ]

            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'placeholder' => 'prenom',
                    'required'
                ]

            ])


            ->add('Specialite', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'placeholder' => 'Specialite',
                    'required'
                ]

            ])
            ->add('Phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'placeholder' => 'Phone',
                    'rows' => '5',
                    'cols' =>
                        'required'
                ]

            ])

            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'placeholder' => 'Email',
                    'required'
                ]

            ])

            ->add('Introduction', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'placeholder' => 'Introduction',
                    'required'
                ]

            ])

            ->add('Etablissement', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'placeholder' => 'Etablissement',
                    'required'
                ]

            ])
            ->add('photo', FileType::class, [
                'label' => 'image ',

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
                            'image/gif',
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'image',
                    ])
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control mt-2',
                    'placeholder' => 'your Password',
                    'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control mt-2',
                    'placeholder' => 'Password',
                    'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])

            ->add('confirmer', SubmitType::class);
    }

}