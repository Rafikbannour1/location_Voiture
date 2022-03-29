<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('code_voiture')
            ->add('marque')
            ->add('modele')
            ->add('nb_places')
            ->add('couleur') 
            ->add('prix') 

          
       ->add('etat', ChoiceType::class    , ['choices'  => [
        'Disponible'=> 'Disponible' ,
        'Non disponible' => 'Non disponible' 
    ]],) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
