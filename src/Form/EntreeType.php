<?php

namespace App\Form;

use App\Entity\Entree;
use App\Entity\Emotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateHeureEntree', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date et heure',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('emotion', EntityType::class, [
                'class' => Emotion::class,
                'choice_label' => 'nomEmotion',
                'label' => 'Émotion ressentie',
                'placeholder' => 'Choisissez une émotion',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaire (optionnel)',
                'attr' => ['rows' => 4, 'class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}
