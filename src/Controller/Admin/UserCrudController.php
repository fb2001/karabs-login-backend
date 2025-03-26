<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;



use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            TextField::new('password')->hideOnIndex(),
            TextField::new('nom'),
            TextField::new('prenom'),
            IntegerField::new('age'),
            TextField::new('numeroTelephone'),
            TextField::new('adresseMail'),
            ImageField::new('photoProfil')
                ->setBasePath('uploads/profils')
                ->setUploadDir('public/uploads/profils')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('notations')->autocomplete(),
            AssociationField::new('enseignesFavorites')->autocomplete(),
        ];
    }
}