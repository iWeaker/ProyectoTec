<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, [
                'attr' => [
                    'placeholder' => 'Numero de control'
                ],
                'label' => false,
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nombre'
                ],
                'label' => false,
            ])
            ->add('lastM',TextType::class, [
                'attr' => [
                    'placeholder' => 'Apellido Paterno'
                ],
                'label' => false,
            ])
            ->add('lastF', TextType::class, [
                'attr' => [
                    'placeholder' => 'Apellido Materno'
                ],
                'label' => false,
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Contraseña'
                ],
                'label' => false,
            ])
            ->add('Registrar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
