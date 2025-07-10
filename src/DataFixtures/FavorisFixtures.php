<?php

namespace App\DataFixtures;

use App\Entity\Favoris;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class FavorisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $favoris = new Favoris();

            /** @var Utilisateur $utilisateur */
            $utilisateur = $this->getReference('utilisateur_' . $i, Utilisateur::class);
            $favoris->setUtilisateur($utilisateur);

            $manager->persist($favoris);

            // Add reference so other fixtures can use this Favoris
            $this->addReference('favoris_' . $i, $favoris);
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
