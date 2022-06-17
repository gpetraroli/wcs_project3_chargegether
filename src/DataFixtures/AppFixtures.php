<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Users fixtures
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

        // Vehicules fixtures
        $vehicule = new Vehicle();
        $vehicule->setBrand("Renault");
        $vehicule->setModel("Zoé");
        $vehicule->setBatteryCapacity('50');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('50');
        $vehicule->setImage("zoe.jpg");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Peugeot");
        $vehicule->setModel("2008");
        $vehicule->setBatteryCapacity('50');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('100');
        $vehicule->setImage("2008.jpg");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("BMW");
        $vehicule->setModel("225 XE");
        $vehicule->setBatteryCapacity('7.6');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('3.7');
        $vehicule->setImage("225_XE.png");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Kia");
        $vehicule->setModel("E soul");
        $vehicule->setBatteryCapacity('64');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('77');
        $vehicule->setImage("e_soul.jpg");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Toyota");
        $vehicule->setModel("Prius");
        $vehicule->setBatteryCapacity('8.8');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('7.7');
        $vehicule->setImage("prius.jpg");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Volkswagen");
        $vehicule->setModel("ID3");
        $vehicule->setBatteryCapacity('45');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('50');
        $vehicule->setImage("ID3.png");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Fiat");
        $vehicule->setModel("500 E");
        $vehicule->setBatteryCapacity('42');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('85');
        $vehicule->setImage("500_E.png");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Ford");
        $vehicule->setModel("Focus");
        $vehicule->setBatteryCapacity('23');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('6.6');
        $vehicule->setImage("focus.jpg");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Hyundai");
        $vehicule->setModel("Ioniq 5");
        $vehicule->setBatteryCapacity('58');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('175');
        $vehicule->setImage("ioniq_5.jpg");
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Mercedes");
        $vehicule->setModel("Class A");
        $vehicule->setBatteryCapacity('15.6');
        $vehicule->setPlugType("to_definite");
        $vehicule->setBatteryPower('3.7');
        $vehicule->setImage("merco.jpg");
        $manager->persist($vehicule);

        $manager->flush();
    }
}
