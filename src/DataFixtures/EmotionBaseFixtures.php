<?php

namespace App\DataFixtures;

use App\Entity\EmotionBase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmotionBaseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Base emotions we will create references for
        $emotionBases = ['Joie', 'Colère', 'Peur', 'Tristesse', 'Surprise', 'Dégoût'];

        // Create an EmotionBase entity for each
        foreach ($emotionBases as $base) {
            $emotionBase = new EmotionBase();
            $emotionBase->setNomEmotionBase($base);

            // Persist to DB
            $manager->persist($emotionBase);

            // IMPORTANT: add a reference using the same exact name
            $this->addReference('emotion_base_' . $base, $emotionBase);
        }

        $manager->flush();
    }
}
