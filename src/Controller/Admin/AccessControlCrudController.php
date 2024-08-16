<?php

namespace App\Controller\Admin;

use App\Entity\AccessControl;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AccessControlCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AccessControl::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('uid'),
            AssociationField::new('epci'),
        ];
    }
    
}
