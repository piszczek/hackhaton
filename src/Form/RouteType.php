<?php

namespace App\Form;

use App\Entity\Point;
use App\Entity\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startAt', DateTimeType::class,[
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('endAt', DateTimeType::class,[
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('isBlocking', CheckboxType::class, [
                'label' => false //label is defined in twig
            ])
//            ->add('blockTime')
            ->add('startPoint', EntityType::class,
                [
                    'class' => Point::class,
                    'mapped' => false,
                    'attr' => ['style' => 'display:none'],
                    'label' => false,
                ]
            )
            ->add('endPoint', EntityType::class,
                [
                    'class' => Point::class,
                    'mapped' => false,
                    'attr' => ['style' => 'display:none'],
                    'label' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Route::class,
        ]);
    }
}
