<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurInfo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UtilisateurFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 🔐 Admin user
        $admin = new Utilisateur();
        $admin->setEmail('admin@cesizen.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpass'));

        $manager->persist($admin);

        // 👥 Regular users
        for ($i = 0; $i < 10; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail("user$i@example.com");

            $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, 'password');
            $utilisateur->setPassword($hashedPassword);

            $manager->persist($utilisateur);
            $this->addReference("utilisateur_$i", $utilisateur);
        }

        $manager->flush();
    }
}
