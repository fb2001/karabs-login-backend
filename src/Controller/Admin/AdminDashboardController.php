<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Enseigne;
use App\Entity\Horaire;
use App\Entity\Notation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(EnseigneCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Karabs Admin')
            ->setFaviconPath('favicon.ico')
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::section('Gestion Commerciale');
        yield MenuItem::linkToCrud('Enseignes', 'fa fa-store', Enseigne::class)
            ->setController(EnseigneCrudController::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-tags', Categorie::class)
            ->setController(CategorieCrudController::class);
        yield MenuItem::linkToCrud('Horaires', 'fa fa-clock', Horaire::class)
            ->setController(HoraireCrudController::class);
            
        yield MenuItem::section('Gestion Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class)
            ->setController(UserCrudController::class);
        yield MenuItem::linkToCrud('Notations', 'fa fa-star', Notation::class)
            ->setController(NotationCrudController::class);
            
        yield MenuItem::section();
        yield MenuItem::linkToUrl('Retour au site', 'fa fa-globe', '/');
    }
}