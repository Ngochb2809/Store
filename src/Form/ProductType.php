<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',  TextType::class,
            [
                'required' => true,
                'label' => 'Product Name',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30
                ]
            ])
            ->add('price', MoneyType::class,
            [
                'required' => true,
                'label' => 'Product Price',
                'currency' => 'USD'
            ])
            ->add('description',TextType::class,
            [
                'required' => true,
                'label' => 'Product description',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 500
                ]
            ])
            ->add('image', TextType::class,
            [
                'label' => 'Product image',
        
            ])
            ->add('quantity', IntegerType::class,
            [
                'required' => true,
                'label' => 'Product Quantity',
                'attr' => [
                    'min' => 1,
                    'max' => 100
                ]
            ])
            ->add('category', EntityType::class,
            [
                 'required' => true,
                 'label' => 'Product category',
                 'class' => Category::class,
                 'choice_label' => 'name',
                 'multiple' => false,
                 'expanded' => true
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
