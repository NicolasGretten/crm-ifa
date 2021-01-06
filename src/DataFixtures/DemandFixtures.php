<?php

namespace App\DataFixtures;

use App\Entity\Demand;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class DemandFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $status = array('Ouverte', 'En cours', 'En attente', 'Fermée');

//        $customer = array();
//        for ($j = 0; $j < 2; $j++) {
//            $customer[$j] = new Demand();
//            $customer[$j]->setUser($this->getDoctrine()
//                ->getRepository(User::class)
//                ->find(mt_rand(0,5)));
//            $customer[$j]->setContent($faker->firstName);
//            $customer[$j]->setStatus('ouverte');
//            $customer[$j]->setViews(false);
//            $customer[$j]->setCreatedAt(new DateTime);
//            $customer[$j]->setUpdatedAt(new DateTime);
//            $manager->persist($customer[$j]);
//        }

        $manager->flush();
    }
}
