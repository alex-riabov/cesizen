<?php

namespace App\DataFixtures;

use App\Entity\Entree;
use App\Entity\Journal;
use App\Entity\Emotion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EntreeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $emotions = $manager->getRepository(Emotion::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            /** @var Journal $journal */
            $journal = $this->getReference('journal_' . $i, Journal::class);

            // Each journal gets between 3 and 5 entries
            $entryCount = rand(3, 5);
            for ($j = 0; $j < $entryCount; $j++) {
                $entree = new Entree();
                $entree->setCommentaire($faker->sentence(15));
                $entree->setDateHeureEntree($faker->dateTimeBetween('-30 days', 'now'));
                $entree->setJournal($journal);
                $entree->setEmotion($faker->randomElement($emotions));

                $manager->persist($entree);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            JournalFixtures::class,
        ];
    }
}
