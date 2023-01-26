<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'id' => 'inputEmail4', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Password',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control', 'id' => 'inputPassword4', 'style' => 'margin-bottom: 10px;'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('fName', TextType::class, [
                'label' => 'First Name',
                'attr' => ['class' => 'form-control', 'id' => 'inputFirstName', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('lName', TextType::class, [
                'label' => 'Last Name',
                'attr' => ['class' => 'form-control', 'id' => 'inputLastName', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('address', TextType::class, [
                'attr' => ['class' => 'form-control', 'id' => 'inputAddress', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('country', TextType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control', 'id' => 'inputState', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('city', TextType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control', 'id' => 'inputCity', 'style' => 'margin-bottom: 10px;']
            ])
            ->add('zip', NumberType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control', 'id' => 'inputZip', 'style' => 'margin-bottom: 10px;']
            ])
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
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
