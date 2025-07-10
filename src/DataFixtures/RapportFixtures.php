<?php

namespace App\DataFixtures;

use App\Entity\Rapport;
use App\Entity\Utilisateur;
use App\Entity\Journal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RapportFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $rapport = new Rapport();
            $startDate = $faker->dateTimeBetween('-3 months', '-1 month');
            $endDate = $faker->dateTimeBetween('-1 month', 'now');

            $rapport->setDateDebutRapport($startDate);
            $rapport->setDateFinRapport($endDate);
            $rapport->setDateCreationRapport($faker->dateTimeBetween($endDate, 'now'));

            // Make sure string doesn't exceed DB column limit
            $contenu = $faker->paragraphs(3, true);
            $rapport->setContenuRapport(substr($contenu, 0, 250));

            // FIXED: pass class as 2nd argument
            $user = $this->getReference('utilisateur_' . $faker->numberBetween(0, 9), Utilisateur::class);
            $journal = $this->getReference('journal_' . $faker->numberBetween(0, 9), Journal::class);

            $rapport->setUtilisateur($user);
            $rapport->setJournal($journal);

            $manager->persist($rapport);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
            JournalFixtures::class,
        ];
    }
}
