<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Votre Mot de Passe actuel',
                'constraints' => [
                    new Assert\NotBlank(),
                    new UserPassword(),
                ],
            ])
            ->add(
                'newPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => [
                        'attr' => [
                            'class' => 'form-control',
                        ],
                        'label' => 'Nouveau Mot de Passe',
                    ],
                    'second_options' => [
                        'attr' => [
                            'class' => 'form-control',
                        ],
                        'label' => 'Confirmation du Mot de Passe'
                    ],
                    'invalid_message' => 'Les Mots de Passe ne correspondent pas.'
                ]
            );
    }
}
