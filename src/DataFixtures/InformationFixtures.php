<?php

namespace App\DataFixtures;

use App\Entity\Information;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class InformationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $information = new Information();
            $information->setNomInformation($faker->sentence(3));
            $information->setContenuInformation($faker->paragraph(2));
            $information->setDateHeureInformation($faker->dateTimeBetween('-30 days', 'now'));

            /** @var Utilisateur $utilisateur */
            $utilisateur = $this->getReference('utilisateur_' . rand(0, 9), Utilisateur::class);
            $information->setUtilisateur($utilisateur);

            $manager->persist($information);

            // ✅ Add reference for later use
            $this->addReference('information_' . $i, $information);
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
