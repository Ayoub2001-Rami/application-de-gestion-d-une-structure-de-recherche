<?php

namespace App\Form;

use App\Entity\Membres;
use App\Entity\Professeur;
use App\Entity\Publication;
use Proxies\__CG__\App\Entity\Master;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('annee')
            ->add('lien')
            ->add('text')
            ->add('Auteur',EntityType::class,[
                'expanded'=>false,
                'required'=>false,
                'class'=>Membres::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ])
            ->add('membres',EntityType::class,[
                'expanded'=>false,
                'required'=>false,
                'class'=>Membres::class,
                'multiple'=>true,
                'attr' => [
                    'class'=>'select2',
                ],
            ])
            ->add('Autre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
