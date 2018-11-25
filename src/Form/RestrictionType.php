<?php

namespace App\Form;

use App\Entity\Restriction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestrictionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('type')
//            ->add('startAt')
//            ->add('endAt')
//            ->add('valueFrom')
            ->add('valueTo', null, [
                'attr' => ['class' => 'textfield__input'],
                'label_attr' => ['class' => 'textfield__label']]
            )
//            ->add('section')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restriction::class,
        ]);
    }
}
