<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Title',
                'constraints' => [
                    new NotBlank([
                        'message' => 'The label is required.'
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'The title length is too important.'
                    ])
                ]
            ])
            ->add('synopsys', TextareaType::class, [
                'label' => 'Synopsys',
                'constraints' => [
                    new Length([
                        'min' => 15,
                        'minMessage' => 'The synopsys length is not enough.'
                    ])
                ]
            ])
            ->add('tagline', null, [
                'label' => 'Tagline',
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'The tagline length is not enough.',
                        'max' => 255,
                        'maxMessage' => 'The tagline length is too important.' 
                    ])
                ]
            ])
            ->add('duration', null, [
                'label' => 'Duration',
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'The movie duration cannot be negative.'
                    ]),
                    new LessThan([
                        'value' => 800,
                        'message' => 'The movie duration is too important.'
                    ])
                ],
                'attr' => [
                    'min' => 0,
                    'max' => 800
                ]
            ])
            ->add('cover', null, [
                'label' => 'Cover image URL',
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'The cover length is too high.'
                    ])
                ]
            ])
            ->add('releasedAt', DateTimeType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
