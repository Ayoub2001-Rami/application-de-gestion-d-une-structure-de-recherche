<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Membres;
use App\Entity\Professeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('domaine')
            ->add('Specialites')
            ->add('chef',EntityType::class,[
                'label' => 'chef d\'Equipe',
                'expanded'=>false,
                'required'=>false,
                'class'=>Professeur::class,
                'multiple'=>false,
                'attr' => [
                    'class'=>'select2',
                ],
            ] )
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
            ->add('labo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
