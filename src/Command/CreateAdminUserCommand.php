<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:user:create-admin', description: 'Create or update the admin user used by the login API.')]
class CreateAdminUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $users,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Admin email address')
            ->addArgument('password', InputArgument::OPTIONAL, 'Admin password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = mb_strtolower($this->normalizeCliValue((string) ($input->getArgument('email') ?: $this->env('ADMIN_EMAIL', 'admin@climbing.live')), 'email='));
        $password = $this->normalizeCliValue((string) ($input->getArgument('password') ?: $this->env('ADMIN_PASSWORD', '')), 'password=');

        if ($email === '' || $password === '') {
            $io->error('Email et mot de passe admin requis. Passe-les en arguments ou via ADMIN_EMAIL et ADMIN_PASSWORD.');
            return Command::INVALID;
        }

        $user = $this->users->findOneBy(['email' => $email]);
        $isNew = $user === null;

        if (!$user) {
            $user = new User();
            $user->setEmail($email);
        }

        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf('%s admin user %s.', $isNew ? 'Created' : 'Updated', $email));

        return Command::SUCCESS;
    }

    private function normalizeCliValue(string $value, string $prefix): string
    {
        $normalized = trim($value);

        if (str_starts_with(mb_strtolower($normalized), $prefix)) {
            return trim(substr($normalized, strlen($prefix)));
        }

        return $normalized;
    }

    private function env(string $key, string $fallback): string
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if (!is_string($value) || $value === '') {
            return $fallback;
        }

        return $value;
    }
}