<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class,
            [
                'required' => true,
                'label' => 'Product Quantity',
                'attr' => [
                    'min' => 1,
                    'max' => 100
                ]
            ])
            ->add('totalprice', MoneyType::class,
            [
                'required' => true,
                'label' => 'Total Price',
                'currency' => 'USD'
            ])
            ->add('datetime', DateType::class,
            [
                'required' => true,
                'label' => 'Date',
                'widget' => 'single_text'
            ])
            ->add('user',  EntityType::class,
            [
                 'required' => true,
                 'label' => 'User',
                 'class' => User::class,
                 
            ])
            ->add('product',  EntityType::class,
            [
                 'required' => true,
                 'label' => 'Product name',
                 'class' => Product::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
