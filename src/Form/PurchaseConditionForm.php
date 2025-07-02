<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Provider;
use App\Entity\PurchaseCondition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseConditionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('provider', EntityType::class, [
                'class' => Provider::class,
                'choice_label' => 'name',
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
            ])
            ->add('price')
            ->add('deliveryTime')
            ->add('minQuantity')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PurchaseCondition::class,
        ]);
    }
}
