<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('quantity')
            ->add('packaging')
            ->add('label')
            ->add('packagingType', ChoiceType::class, [
                'choices' => [
                    $this->translator->trans('Liter') => 'l',
                    $this->translator->trans('Gram') => 'g'
                ],
                'placeholder' => $this->translator->trans('Choose a type'),
            ])
            ->add('quantityPerPiece')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'placeholder' => $this->translator->trans('Choose a category'),
                'required' => true,
                'label' => 'Category',
                'mapped' => true,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
