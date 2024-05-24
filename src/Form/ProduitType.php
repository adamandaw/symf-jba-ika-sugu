<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('provenance')
            ->add('description')
            ->add('prixDeVente', NumberType::class, [
                'label' => 'Prix de Vente',
                'required' => true,
                'scale' => 2, // nombre de décimales
                'html5' => true, // affichage des séparateurs de milliers
            ])
            ->add('quantite')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'libelle',
            ])
            ->add('thumbnailFile',FileType::class,[
                'label' => 'Image',
                'required' => false, 
                'mapped' => false, 
                'constraints' => [
                    new Image([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'maxSizeMessage' =>'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est de {{ limit }} {{ suffix }}.',
                        'mimeTypesMessage' => 'Veuillez télécharger une image au format PNG, JPEG ou JPG.',
                    ])]
            ])
            ->add('thumbnailPremiereImage',FileType::class,[
                'label' => 'Image 1',
                'required' => false, 
                'mapped' => false, 
                'constraints' => [
                    new Image([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'maxSizeMessage' =>'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est de {{ limit }} {{ suffix }}.',
                        'mimeTypesMessage' => 'Veuillez télécharger une image au format PNG, JPEG ou JPG.',
                    ])]
            ])
            ->add('thumbnailSecondeImage',FileType::class,[
                'label' => 'Image 2',
                'required' => false, 
                'mapped' => false, 
                'constraints' => [
                    new Image([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'maxSizeMessage' =>'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est de {{ limit }} {{ suffix }}.',
                        'mimeTypesMessage' => 'Veuillez télécharger une image au format PNG, JPEG ou JPG.',
                    ])]
            ])
            ->add('thumbnailDerniereImage',FileType::class,[
                'label' => 'Image 3',
                'required' => false, 
                'mapped' => false, 
                'constraints' => [
                    new Image([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'maxSizeMessage' =>'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est de {{ limit }} {{ suffix }}.',
                        'mimeTypesMessage' => 'Veuillez télécharger une image au format PNG, JPEG ou JPG.',
                    ])]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
