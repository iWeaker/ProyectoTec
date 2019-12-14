<?php

namespace App\Form;

use App\Entity\GroupEntity;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleGroup' , TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titulo del grupo'
                ]
            ])
            ->add('tematica' , TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Tema del grupo'
                ]
            ])
            ->add('groupImage', FileType::class)
            ->add('Crear', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupEntity::class,
        ]);
    }
}
