<?php

namespace App\Form;

use App\Entity\EventLogistoc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventLogisticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom de la logistic', 'attr' => ['class' => 'form-control'], 'required' => false])
            ->add('description', TextareaType::class, ['label' => 'description de la logistic', 'attr' => ['class' => 'form-control'], 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventLogistoc::class,
        ]);
    }
}
