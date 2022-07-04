<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'minlenght' => '2',
                    'maxlenght' => '255',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 255])
                ],
                'label' => 'Email',
            ])
            ->add('userName', TextType::class, [
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 45])
                ],
                'label' => 'Pseudo',
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255])
                ],
                'label' => 'Adresse',
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 80])
                ],
                'label' => 'Ville',
            ])
            ->add('zipcode', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 10])
                ],
                'label' => 'Code Postal'
            ])
            ->add('country', CountryType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 80])
                ],
                'label' => 'Pays',
            ])
            ->add('phoneNumber', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 20])
                ],
                'label' => 'Téléphone',
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo de Profile',
                'label_attr' => [
                    'class' => 'form-label my-3',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'm-4 text-center
                    col-9 d-flex align-items-center
                    justify-content-center
                     rounded-pill bg-primary gap-3
                     text-white my-2 bi bi-check-circle-fill'
                ],
                'label' => 'S\' Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
