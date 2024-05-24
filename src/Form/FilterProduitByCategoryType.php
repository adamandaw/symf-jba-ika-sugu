<?php

namespace App\Form;

use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilterProduitByCategoryType extends AbstractType
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libelle',ChoiceType::class,[
            'label' => false,
            'choice_label' => 'libelle',
            'choices' =>  $this->categoryRepository->findAll(),
            'required'=>false,
                'constraints'=>[
                    new NotBlank(['message'=>'le libelle est obligatoire.'])
                ],
                "attr"=>[
                    "placeholder"=>"Rechercher par category"
                ]
        ])
        ->add('save',SubmitType::class,[
            "label"=>"Rechercher",
            "attr"=>[
                "class"=>"btn-dark  btn-sm",
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
