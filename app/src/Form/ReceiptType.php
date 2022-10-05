<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Receipt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReceiptType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('receiptDate', DateType::class, [
                //'html5' => false,
                'widget' => 'single_text',
                'placeholder' => 'Select a value',
            ])
            ->add('packaging')
            ->add('label')
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'placeholder' => $this->translator->trans('choose.a.product'),
                'required' => true,
                'label' => 'Receipt',
                'mapped' => true,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Receipt::class,
        ]);
    }
}
