<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('matricule', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('CIN', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('passport', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])

            ->add('tel', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('section_bac', ChoiceType::class, [
                'choices'  => [
                    'INFO' => 'INFO',
                    'LETTRE' => "LETTRE",
                    'ECO' => "ECO",
                    'MATH' => "MATH",
                    'TECH' => "TECH",
                ],
                'required' => false
            ])
            ->add('date_bac', DateTimeType::class, ['required' => false])
            ->add('birthday', DateTimeType::class, ['required' => false])
            ->add('is_valid', CheckboxType::class, [
                'attr' => ['class' => 'custom-control-input'],
                'label' => 'Valid',
                'label_attr' => ['class' => 'custom-control-label'],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
