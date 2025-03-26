<?php

namespace App\Controller\Admin;

use App\Entity\Notation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
class NotationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Notation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setSearchFields(['typeNotation', 'user.email', 'enseigne.nom']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('prix')->setLabel('Note prix (1-5)'),
            IntegerField::new('ambiance')->setLabel('Note ambiance (1-5)'),
            IntegerField::new('qualite')->setLabel('Note qualité (1-5)'),
            TextField::new('typeNotation')->setLabel('Type de notation'),
            AssociationField::new('user')
                ->autocomplete()
                ->setCrudController(UserCrudController::class),
            AssociationField::new('enseigne')
                ->autocomplete()
                ->setCrudController(EnseigneCrudController::class),
        ];
    }
}
