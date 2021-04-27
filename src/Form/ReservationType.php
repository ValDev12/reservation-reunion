<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateD')
            ->add('dateF')
            ->add('participant',ChoiceType::class ,[
                'choices' => $options['utilisateurs'],
                'choice_label' => 'nom',
            ])
            ->add('salle',ChoiceType::class ,[
                'choices' => $options['salles'],
                'choice_label' => 'libelle',
            ])
            ->add('envoie',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'utilisateurs'=>[],
            'salles'=>[],
        ]);
    }
}
