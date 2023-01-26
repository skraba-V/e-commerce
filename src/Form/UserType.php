<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            // ->add('roles')
            // ->add('password')
            ->add('fName', TextType::class, [
                'label' => 'First Name',
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('lName', TextType::class, [
                'label' => 'Last Name',
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('address', TextType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            ])
            // ->add('banStatus')
            // ->add('isVerified')
            // ->add('country', TextType::class, [
            //     'mapped' => false,
            //     'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            // ])
            // ->add('city', TextType::class, [
            //     'mapped' => false,
            //     'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            // ])
            // ->add('zip', NumberType::class, [
            //     'mapped' => false,
            //     'attr' => ['class' => 'form-control', 'style' => 'margin-bottom: 10px;']
            // ])
            ->add('pictureUrl', FileType::class, [
                'label' => 'Upload Picture',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
