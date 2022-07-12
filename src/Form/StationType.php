<?php

namespace App\Form;

use App\Config\PlugType;
use App\Config\StationPower;
use App\Entity\Station;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class StationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('coordinates', TextType::class, [
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('plugType', EnumType::class, [
                'class' => PlugType::class,
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('power', EnumType::class, [
                'class' => StationPower::class,
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [new Assert\NotBlank()],
            ])
            ->add('enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Station::class,
        ]);
    }
}
