<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProdCategory;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('description', TextType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('price', NumberType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('size', NumberType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('weight', NumberType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('stock', NumberType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('discount', NumberType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;'],
                'required' => false,
            ])
            ->add('fk_category', EntityType::class, [
                'class' => ProdCategory::class,
                'choice_label' => 'name',
            ])
            ->add('fk_supplier', EntityType::class, [
                'class' => Supplier::class,
                'choice_label' => 'name',
            ])
            ->add('pictureUrl', FileType::class, [
                'label' => 'Upload Picture',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
