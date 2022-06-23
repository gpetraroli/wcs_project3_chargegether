<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUserName($faker->userName);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setGender($faker-> randomElement(['M', 'F']));
            $user->setBirthDate($faker->dateTimeBetween('-80 years', '-18 years'));
            $user->setAddress($faker->address);
            $user->setPhoneNumber($faker->phoneNumber);
            $user->setCity($faker->city);
            $user->setZipcode($faker->postcode);
            $user->setCountry($faker->country);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);

            $manager->persist($user);
        }

        $user = new User();
        $user->setUserName("Admin");
        $user->setFirstname("Firstname");
        $user->setLastname("Lastname");
        $user->setGender('M');
        $user->setBirthDate($faker->dateTimeBetween('-80 years', '-18 years'));
        $user->setAddress($faker->address);
        $user->setPhoneNumber($faker->phoneNumber);
        $user->setCity($faker->city);
        $user->setZipcode($faker->postcode);
        $user->setCountry($faker->country);
        $user->setEmail("admin@admin.fr");
        $user->setPassword("password");

        $manager->persist($user);

        $manager->flush();
    }
}
