<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud):Crud
    {
        return $crud
            ->setEntityLabelInPlural('Messages')
            ->setEntityLabelInSingular('Message')
            ->setDateTimeFormat('%%y %%m %%d')
            ->setPageTitle("index", "TraiteApp | msg ")
            ->setPaginatorPageSize(15);
            
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('fullName'),
            TextField::new('email')->setFormTypeOption('disabled','disabled'),
            TextField::new('subject'),
            TextareaField::new('message')->hideOnIndex(),
            DateTimeField::new('createdAt')->setFormTypeOption('disabled','disabled'),
        ];
    }
    
}
