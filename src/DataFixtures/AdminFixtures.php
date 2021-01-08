<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('crm-ifa@yopmail.com');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            strtolower('0000')
        ));
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setCreatedAt(new DateTime());
        $admin->setUpdatedAt(new DateTime());
        $manager->persist($admin);

        $manager->flush();
    }
}
