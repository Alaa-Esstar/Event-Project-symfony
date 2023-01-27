<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventLogistoc;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Nom de l'evenement"
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('date_start', DateTimeType::class, [
                'label' => "Date de l'evenement"
            ])
            ->add('place', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Lieu de l'evenement"
            ])
            ->add('price', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Prix de l'evenement"
            ])

            ->add('date_end', DateTimeType::class, [
                'label' => "Date de l'evenement"
            ])
            ->add('is_valid', CheckboxType::class, [
                'attr' => ['class' => 'custom-control-input'],
                'label' => 'Valid',
                'label_attr' => ['class' => 'custom-control-label'],
                'required' => false,
            ])
            ->add('is_archive', CheckboxType::class, [
                'attr' => ['class' => 'custom-control-input'],
                'label' => 'Archiver',
                'label_attr' => ['class' => 'custom-control-label'],
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'attr' => ['class' => 'custom-select'],
                'label' => 'Créer par'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
