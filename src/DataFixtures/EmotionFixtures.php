<?php

namespace App\DataFixtures;

use App\Entity\Emotion;
use App\Entity\EmotionBase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EmotionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Mapping each base emotion -> list of sub-emotions
        $emotionsMap = [
            'Joie' => [
                'Fierté',
                'Contentement',
                'Enchantement',
                'Excitation',
                'Émerveillement',
                'Gratitude',
            ],
            'Colère' => [
                'Frustration',
                'Irritation',
                'Rage',
                'Ressentiment',
                'Agacement',
                'Hostilité',
            ],
            'Peur' => [
                'Inquiétude',
                'Anxiété',
                'Terreur',
                'Appréhension',
                'Panique',
                'Crainte',
            ],
            'Tristesse' => [
                'Chagrin',
                'Mélancolie',
                'Abattement',
                'Désespoir',
                'Solitude',
                'Dépression',
            ],
            'Surprise' => [
                'Étonnement',
                'Stupéfaction',
                'Sidération',
                'Incrédulité',
                'Émerveillement', // appears in both Joie & Surprise
            ],
            'Dégoût' => [
                'Confusion',
                'Répulsion',
                'Déplaisir',
                'Nausée',
                'Dédain',
                'Horreur',
                'Dégoût profond',
            ]
        ];

        // Loop over the map
        foreach ($emotionsMap as $base => $emotions) {
            // Use the exact reference name from EmotionBaseFixtures
            /** @var EmotionBase $emotionBase */
            $emotionBase = $this->getReference('emotion_base_' . $base, EmotionBase::class);
            // Create each sub-emotion and link it
            foreach ($emotions as $emotionName) {
                $emotion = new Emotion();
                $emotion->setNomEmotion($emotionName);
                $emotion->setEmotionBase($emotionBase);

                $manager->persist($emotion);
            }
        }

        $manager->flush();
    }

    // Ensure EmotionBaseFixtures loads first
    public function getDependencies(): array
    {
        return [
            EmotionBaseFixtures::class,
        ];
    }
}
