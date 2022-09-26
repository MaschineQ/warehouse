<?php

namespace App\Form;

use App\Entity\Expedition;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpeditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('expeditionDate', DateType::class, [
                //'html5' => false,
                'widget' => 'single_text',
                'placeholder' => 'Select a value',
            ])
            ->add('packaging')
            ->add('label')
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'placeholder' => 'Choose a product',
                'required' => true,
                'label' => 'Receipt',
                'mapped' => true,
                'choice_label' => 'name',
            ])
            ->add('quantity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expedition::class,
        ]);
    }
}
