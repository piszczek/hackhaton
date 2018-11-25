<?php

namespace App\Form;

use App\Entity\Point;
use App\Entity\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startAt')
            ->add('endAt')
            ->add('isBlocking')
            ->add('blockTime')
            ->add('startPointId', TextType::class, ['mapped' => false])
            ->add('endPointId', TextType::class, ['mapped' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Route::class,
        ]);
    }
}
