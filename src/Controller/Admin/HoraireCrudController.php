<?php

namespace App\Controller\Admin;

use App\Entity\Horaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


use App\Enum\JourEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
class HoraireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Horaire::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Horaires des enseignes')
            ->setSearchFields(['jour', 'enseigne.nom']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('jour')
                ->setChoices(JourEnum::cases())
                ->setLabel('Jour de la semaine'),
            TimeField::new('heureOuverture')->setLabel('Ouverture'),
            TimeField::new('heureFermeture')->setLabel('Fermeture'),
            AssociationField::new('enseigne')
                ->autocomplete()
                ->setCrudController(EnseigneCrudController::class),
        ];
    }
}