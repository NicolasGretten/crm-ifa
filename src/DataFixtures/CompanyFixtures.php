<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');
        $company = array();
        for ($i = 0; $i < 5; $i++) {
            $company[$i] = new Company();
            $company[$i]->setName($faker->company);
            $company[$i]->setAddress($faker->streetAddress);
            $company[$i]->setCity($faker->city);
            $company[$i]->setZipCode($faker->postcode);
            $company[$i]->setEmailAddress($faker->email);
            $company[$i]->setPhoneNumber($faker->phoneNumber);
            $manager->persist($company[$i]);

            $customer = array();
            for ($j = 0; $j < 2; $j++) {
                $customer[$j] = new Customer();
                $customer[$j]->setCompany($company[$i]);
                $customer[$j]->setFirstName($faker->firstName);
                $customer[$j]->setLastName($faker->lastName);
                $customer[$j]->setAccess(false);
                $customer[$j]->setEmailAddress($faker->email);
                $manager->persist($customer[$j]);
            }
        }

        $manager->flush();
    }
}
