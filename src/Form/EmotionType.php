<?php

namespace App\Form;

use App\Entity\Emotion;
use App\Entity\EmotionBase;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEmotion')
            ->add('emotionBase', EntityType::class, [
                'class' => EmotionBase::class,
                'choice_label' => 'nomEmotionBase', // ✅ fixed
                'label' => 'Émotion de base',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emotion::class,
        ]);
    }
}
