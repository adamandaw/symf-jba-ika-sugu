<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,[
                'label' => "Libelle",
                'required'=>false,
                    'constraints'=>[
                        new NotBlank(['message'=>'le libelle est obligatoire.'])
                    ],
                    "attr"=>[
                        "placeholder"=>"Saisir libelle"
                    ]
            ])
            ->add('save',SubmitType::class,[
                "label"=>"Enregistrer",
                "attr"=>[
                    "class"=>"btn-primary  btn-sm float-right",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
