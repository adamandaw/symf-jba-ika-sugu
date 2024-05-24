<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
        {
            return $crud
                ->setEntityLabelInSingular('Category')
                ->setEntityLabelInPlural('Listes Category')
                ->setSearchFields(['author', 'text', 'email'])
                ->setPaginatorPageSize(20)
                ->setPaginatorRangeSize(5);
                // ->setDefaultSort(['createdAt' => 'DESC'])
            ;
        }
    
    public function configureFields(string $pageName): iterable
    {
        // $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
        //                 'years' => range(date('Y'), date('Y')  5),
        //                 'widget' => 'single_text',
        //             ]);
        return [
            // IdField::new('id'),
            TextField::new('libelle'),
            // TextEditorField::new('description'),
            // DateTimeField::new('createdAt'),
        ];
    }
    
}
