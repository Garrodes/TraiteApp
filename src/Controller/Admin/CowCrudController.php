<?php

namespace App\Controller\Admin;

use App\Entity\Cow;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CowCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cow::class;
    }


    public function configureCrud(Crud $crud):Crud
    {
        return $crud
            ->setEntityLabelInPlural('Cows')
            ->setEntityLabelInSingular('Cow')
            ->setDateTimeFormat('%%y %%m %%d');
            
            
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('imageName'),
            DateTimeField::new('dob'),
            IntegerField::new('idNat'),
            // custom field for herd / breed / health ?
        ];
    }

}
