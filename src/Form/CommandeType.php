<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('telephone',TextType::class,
            [
                'required'   => false,
                'label'   => "Téléphone",
                'attr' => [
                    'placeholder' => 'Saisir téléphone',
                    'class' => 'telephone-mask',
                ],
                'constraints'=>[
                    new NotBlank(['message'=>"Le téléphone est obligatoire."]),
                ],
            ])
            // ->add('montant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
