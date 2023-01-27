<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventLogistoc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $event = $event->getData();
                // $form = $event->getForm();
    
                if (null === $event->getId()) {
                    // If the event is being created, add an empty logistic to the form
                    $event->addEventLogistoc(new EventLogistoc());
                }
            }
        );

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

            ->add(
                'eventLogistocs',
                CollectionType::class,
                [
                    'label' => ' ', "required" => true,
                    'entry_type' => EventLogisticType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
