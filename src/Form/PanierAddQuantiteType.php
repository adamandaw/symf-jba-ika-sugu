<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierAddQuantiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité',
                'required' => true,
                "attr"=>[
                    "placeholder"=>"Saisir quantité"
                ] ,
                'html5' => true, // affichage des séparateurs de milliers
            ])
            ->add('save',SubmitType::class,[
                "label"=>"Ajouter",
                "attr"=>[
                    "class"=>"btn  btn-sm float-right",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
