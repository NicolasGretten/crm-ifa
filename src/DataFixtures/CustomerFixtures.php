<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Customer;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $customer = array();
        for ($j = 0; $j < 2; $j++) {
            $customer[$j] = new Customer();
            $customer[$j]->setCompany($this->getDoctrine()
                ->getRepository(Company::class)
                ->find(mt_rand(0,5)));
            $customer[$j]->setFirstName($faker->firstName);
            $customer[$j]->setLastName($faker->lastName);
            $customer[$j]->setAccess(false);
            $customer[$j]->setEmailAddress($faker->email);
            $customer[$j]->setCreatedAt(new DateTime);
            $customer[$j]->setUpdatedAt(new DateTime);
            $manager->persist($customer[$j]);
        }
        $manager->flush();
    }
}
