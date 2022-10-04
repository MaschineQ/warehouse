<?php

namespace App\Form;

use App\Entity\Expedition;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExpeditionType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('expeditionDate', DateType::class, [
                'widget' => 'single_text',
                'placeholder' => 'Select a value',
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'placeholder' => $this->translator->trans('choose.a.product'),
                'required' => true,
                'label' => 'Product',
                'mapped' => true,
                'choice_label' => 'name',
            ])
            ->add('quantity', null, [
                'mapped' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expedition::class,
        ]);
    }
}
