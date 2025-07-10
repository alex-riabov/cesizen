<?php

namespace App\DataFixtures;

use App\Entity\Journal;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class JournalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $journal = new Journal();

            /** @var Utilisateur $utilisateur */
            $utilisateur = $this->getReference('utilisateur_' . $i, Utilisateur::class);
            $journal->setUtilisateur($utilisateur);

            $manager->persist($journal);

            // Add reference so other fixtures (like RapportFixtures) can use it
            $this->addReference('journal_' . $i, $journal);
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
