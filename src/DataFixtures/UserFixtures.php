<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $john = $manager->getRepository(Customer::class)
            ->findBy(['email_address' => 'john@doe.com']);
        $user = new User();
        $user->setCustomer($john[0]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, strtolower('john.doe')));
        $user->setRoles(["ROLE_USER"]);
        $user->setEmail('john@doe.com');
        $user->setCreatedAt(new DateTime);
        $user->setUpdatedAt(new DateTime);
        $manager->persist($user);

        $manager->flush();
    }
}
