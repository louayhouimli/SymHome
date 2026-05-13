<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control rounded-3 p-3 border-0 shadow-sm'
                ]
            ])

            ->add('total', null, [
                'attr' => [
                    'class' => 'form-control rounded-3 p-3 border-0 shadow-sm'
                ]
            ])

            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'en_attente',
                    'En cours' => 'en_cours',
                    'Complétée' => 'completee'
                ],
                'attr' => [
                    'class' => 'form-select rounded-3 p-3 border-0 shadow-sm'
                ]
            ])

            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'attr' => [
                    'class' => 'form-select rounded-3 p-3 border-0 shadow-sm'
                ]
            ])

            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn w-100 text-white rounded-3 p-3',
                    'style' => 'background-color:#5D4037; border:none;'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}