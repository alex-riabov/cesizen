<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurInfo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class UtilisateurInfoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $utilisateurInfo = new UtilisateurInfo();
            $utilisateurInfo->setNomUtilisateur($faker->lastName());
            $utilisateurInfo->setPrenomUtilisateur($faker->firstName());

            // ❗️Corrected method name
            $utilisateurInfo->setDateNaissanceUtilisateur(
                $faker->dateTimeBetween('-30 years', '-18 years')
            );


            // Link to corresponding Utilisateur
            $utilisateur = $this->getReference("utilisateur_$i", Utilisateur::class);
            $utilisateurInfo->setUtilisateur($utilisateur);

            $manager->persist($utilisateurInfo);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
        ];
    }
}
