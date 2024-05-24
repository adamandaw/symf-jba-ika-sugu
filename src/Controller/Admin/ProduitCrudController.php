<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Produit;
use Doctrine\ORM\Mapping\Entity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Listes des Produits')
            ->setSearchFields(['author', 'text', 'email'])

            // ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('libelle'),
            NumberField::new('quantite'),
            AssociationField::new('category')
            ->setFormTypeOptions([
                'class' => Category::class,
                'choice_label' => 'libelle',
            ]),
            // ->setLabel('Category'),
            // TextEditorField::new('description'),
        ];
    }
    
}
