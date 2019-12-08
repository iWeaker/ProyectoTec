<?php

namespace App\Form;

use App\Entity\PostEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contentPost', TextareaType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Ingresa tu noticia'],
                'required' => false

            ])
            ->add('imagePost', FileType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('Publicar' , SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostEntity::class,
        ]);
    }
}
