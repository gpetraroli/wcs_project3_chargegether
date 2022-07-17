<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\User;
use App\Entity\Vehicle;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class BookingType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User|null $user */
        $user = $this->security->getUser();

        $builder
            ->add('startRes', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'label' => 'Début de la réservation',
                'data' => new DateTimeImmutable()
            ])

            ->add('endRes', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'label' => 'Fin de la réservation',
                'data' => new DateTimeImmutable()
            ])
            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'choices' => $user->getVehicles(),
                'choice_label' => 'model',
                'label' => 'Véhicule pris en charge',
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
