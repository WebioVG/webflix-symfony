<?php

namespace App\Form;

use App\Entity\Movies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MoviesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TypeTextType::class, [
                'attr' => [
                    'placeholder' => 'Movie title...',
                    'class' => 'border px-2'
                ]
            ])
            ->add('synopsys', TypeTextType::class, [
                'attr' => [
                    'placeholder' => 'Movie synopsys...',
                    'class' => 'border px-2'
                ]
            ])
            ->add('duration', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Movie duration (min)...',
                    'class' => 'border px-2'
                ]
            ])
            ->add('youtube', TypeTextType::class, [
                'attr' => [
                    'placeholder' => 'Trailer Youtube link...',
                    'class' => 'border px-2'
                ]
            ])
            ->add('cover', TypeTextType::class, [
                'attr' => [
                    'placeholder' => 'Cover url...',
                    'class' => 'border px-2'
                ]
            ])
            ->add('releasedAt', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movies::class,
        ]);
    }
}
