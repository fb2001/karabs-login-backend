<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Crée un utilisateur administrateur pour le backoffice',
)]
class CreateAdminCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->setHelp('Cette commande permet de créer un utilisateur administrateur')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
    
        $user = new User();
        $user->setEmail('admin@karabs.com');
        
        // Hashage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user, // Doit implémenter PasswordAuthenticatedUserInterface
            'motdepasse' // À changer en production !
        );
        $user->setPassword($hashedPassword);
        
        $user->setNom('Admin');
        $user->setPrenom('System');
        $user->setAge(30);
        $user->setRoles(['ROLE_ADMIN']);
    
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    
        $io->success('Administrateur créé avec succès !');
        return Command::SUCCESS;
    }
}