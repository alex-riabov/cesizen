<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurInfo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUtilisateur')
            ->add('prenomUtilisateur')
            ->add('dateNaissanceUtilisateur', null, [
                'widget' => 'single_text'
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UtilisateurInfo::class,
        ]);
    }
}
