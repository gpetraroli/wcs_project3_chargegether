<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
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
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 80])
                ],
                'label' => 'Nom',
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 80])
                ],
                'label' => 'Prénom',
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
            ->add('birthDate', DateType::class, [
                'label' => 'Date de Naissance',
                'widget' => 'single_text',
                'required' => false
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
                'preferred_choices' => ['FR'],
            ])
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Un Homme' => true,
                    'Une Femme' => false,
                    'Autres' => 'null',
                ],
                'label' => 'Je suis...',
            ])
            ->add('phoneNumber', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 20])
                ],
                'label' => 'Téléphone',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter nos conditions.',
                    ]),
                ],
                'label' => 'En m\'inscrivant sur ce site j\'accepte les conditions...'
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de Passe',
                    'label_attr' => [
                        'class' => 'form-label'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
