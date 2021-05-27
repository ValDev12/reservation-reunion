<?php

namespace App\Form;
use App\Entity\Utilisateur;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateD', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date Début',
            ])
            ->add('dateF', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date Fin',
            ])
            ->add('participant', EntityType::class, [
                'class' => Utilisateur::class,
                'choices' => $options['participant'],
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('salle',ChoiceType::class ,[
                'choices' => $options['salles'],
                'choice_label' => 'libelle',
            ])
            ->add('Valider',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'participant'=>[],
            'salles'=>[],
        ]);
    }
}
