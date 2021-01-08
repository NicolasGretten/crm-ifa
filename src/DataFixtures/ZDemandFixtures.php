<?php

namespace App\DataFixtures;

use App\Entity\Demand;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ZDemandFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $demand = new Demand();
        $john = $manager->getRepository(User::class)
            ->findBy(['email' => 'john@doe.com']);
        $demand->setUser($john[0]);
        $demand->setContent($faker->sentence($nbWords = 35));
        $demand->setStatus('Waiting');
        $demand->setViews(false);
        $demand->setCreatedAt(new DateTime);
        $demand->setUpdatedAt(new DateTime);
        $manager->persist($demand);


        $manager->flush();
    }
}
