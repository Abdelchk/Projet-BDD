<?php

// src/Command/CreateAdminCommand.php
namespace App\Command;

use App\Entity\Utilisateur;
use App\Entity\Profil;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsCommand(
    name: 'app:create-admin',
    description: 'Create an admin user.'
)]
class CreateAdminCommand extends Command
{
    // protected static $defaultName = 'app:create-admin';

    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure()
    {
        $this->setDescription('Create an admin user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $output->writeln('Creating a new admin user.');

        $user = new Utilisateur();
        $user->setNom('Cisse');
        $user->setPrenom('Mounirou');
        $user->setEmail('admin.mc@destination.com');
        $password = 'azerty';
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setIsAdmin(true);
        $profil = new Profil();
        $user->setProfil($profil); // Assuming you want to set this to null for now

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Admin user created successfully.');

        return Command::SUCCESS;
    }
}