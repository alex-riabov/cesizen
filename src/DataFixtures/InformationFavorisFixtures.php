<?php

namespace App\DataFixtures;

use App\Entity\InformationFavoris;
use App\Entity\Information;
use App\Entity\Favoris;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InformationFavorisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $usedPairs = [];

        while (count($usedPairs) < 10) {
            $infoIndex = rand(0, 9);
            $favIndex = rand(0, 9);
            $pairKey = "$infoIndex-$favIndex";

            if (isset($usedPairs[$pairKey])) {
                continue; // Skip duplicate pair
            }

            $usedPairs[$pairKey] = true;

            $information = $this->getReference('information_' . $infoIndex, Information::class);
            $favoris = $this->getReference('favoris_' . $favIndex, Favoris::class);

            $infoFavoris = new InformationFavoris();
            $infoFavoris->setInformation($information);
            $infoFavoris->setFavoris($favoris);

            $manager->persist($infoFavoris);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            InformationFixtures::class,
            FavorisFixtures::class,
        ];
    }
}
