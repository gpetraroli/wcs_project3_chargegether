<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Vehicle;
use App\Config\PlugType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        // Vehicules fixtures
        $vehicule = new Vehicle();
        $vehicule->setBrand("Renault");
        $vehicule->setModel("Zoé");
        $vehicule->setBatteryCapacity('50');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('50');
        $vehicule->setImage("zoe.jpg");
        $this->addReference('Zoé', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Peugeot");
        $vehicule->setModel("2008");
        $vehicule->setBatteryCapacity('50');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('100');
        $vehicule->setImage("2008.jpg");
        $this->addReference('2008', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("BMW");
        $vehicule->setModel("225 XE");
        $vehicule->setBatteryCapacity('7.6');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('3.7');
        $vehicule->setImage("225_XE.png");
        $this->addReference('225_XE', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Kia");
        $vehicule->setModel("E soul");
        $vehicule->setBatteryCapacity('64');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('77');
        $vehicule->setImage("e_soul.jpg");
        $this->addReference('E_soul', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Toyota");
        $vehicule->setModel("Prius");
        $vehicule->setBatteryCapacity('8.8');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('7.7');
        $vehicule->setImage("prius.jpg");
        $this->addReference('Prius', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Volkswagen");
        $vehicule->setModel("ID3");
        $vehicule->setBatteryCapacity('45');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('50');
        $vehicule->setImage("ID3.png");
        $this->addReference('ID3', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Fiat");
        $vehicule->setModel("500 E");
        $vehicule->setBatteryCapacity('42');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('85');
        $vehicule->setImage("500_E.png");
        $this->addReference('500_E', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Ford");
        $vehicule->setModel("Focus");
        $vehicule->setBatteryCapacity('23');
        $vehicule->setPlugType("Type.1");
        $vehicule->setBatteryPower('6.6');
        $vehicule->setImage("focus.jpg");
        $this->addReference('focus', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Hyundai");
        $vehicule->setModel("Ioniq 5");
        $vehicule->setBatteryCapacity('58');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('175');
        $vehicule->setImage("ioniq_5.jpg");
        $this->addReference('ioniq_5', $vehicule);
        $manager->persist($vehicule);

        $vehicule = new Vehicle();
        $vehicule->setBrand("Mercedes");
        $vehicule->setModel("Class A");
        $vehicule->setBatteryCapacity('15.6');
        $vehicule->setPlugType("Type.2");
        $vehicule->setBatteryPower('3.7');
        $vehicule->setImage("merco.jpg");
        $this->addReference('merco', $vehicule);
        $manager->persist($vehicule);


        // Users fixtures
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUserName($faker->userName);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setGender($faker->randomElement(['H', 'F']));
            $user->setBirthDate($faker->dateTimeBetween('-80 years', '-18 years'));
            $user->setAddress($faker->address);
            $user->setPhoneNumber($faker->phoneNumber);
            $user->setCity($faker->city);
            $user->setZipcode($faker->postcode);
            $user->setCountry($faker->country);
            $user->setEmail($faker->email);
            $user->setPassword($this->hasher->hashPassword($user, 'user'));
            $user->addVehicle($this->getReference('merco'));
            $manager->persist($user);
        }

        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setUserName("admin");
        $user->setFirstname("firstname");
        $user->setLastname("lastname");
        $user->setGender('M');
        $user->setBirthDate($faker->dateTimeBetween('-80 years', '-18 years'));
        $user->setAddress($faker->address);
        $user->setPhoneNumber($faker->phoneNumber);
        $user->setCity($faker->city);
        $user->setZipcode($faker->postcode);
        $user->setCountry($faker->country);
        $user->setEmail("admin@admin.fr");
        $user->setPassword($this->hasher->hashPassword($user, 'NC$68^cdk@fp'));
        $user->addVehicle($this->getReference('focus'));

        $manager->persist($user);

        $manager->flush();
    }
}
