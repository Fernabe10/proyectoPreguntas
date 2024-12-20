<?php

namespace App\Form;

use App\Entity\Pregunta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PreguntaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título de la pregunta'
            ])
            ->add('fechaInicio', DateTimeType::class, [
                'label' => 'Fecha de inicio',
                'widget' => 'single_text',
            ])
            ->add('fechaFin', DateTimeType::class, [
                'label' => 'Fecha de fin',
                'widget' => 'single_text',
            ])
            ->add('respuesta1', TextType::class, [
                'label' => 'Respuesta 1'
            ])
            ->add('respuesta2', TextType::class, [
                'label' => 'Respuesta 2'
            ])
            ->add('respuesta3', TextType::class, [
                'label' => 'Respuesta 3',
                'required' => false, // opcional
            ])
            ->add('respuesta4', TextType::class, [
                'label' => 'Respuesta 4',
                'required' => false, // opcional
            ])
            ->add('respuestaCorrecta', TextType::class, [
                'label' => 'Respuesta Correcta',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pregunta::class,
        ]);
    }
}
