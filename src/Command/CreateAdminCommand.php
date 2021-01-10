<?php

namespace App\Command;

use App\Entity\User;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';
    private $passwordEncoder;
    private $requirePassword;
    private $container;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ContainerInterface $container, bool $requirePassword = false)
    {
        $this->requirePassword = $requirePassword;
        $this->passwordEncoder = $passwordEncoder;

        parent::__construct();

        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new admin.')
            ->setHelp('This command allows you to create an admin...')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email address for the admin.')
            ->addArgument('password', $this->requirePassword ? InputArgument::REQUIRED : InputArgument::OPTIONAL, 'Admin password')            // ...
        ;
    }

// ...
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->container->get('doctrine')->getManager();
        $admin = new User();
        $admin->setEmail($input->getArgument('email'));
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            strtolower('0000')
        ));
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setCreatedAt(new DateTime());
        $admin->setUpdatedAt(new DateTime());
        $em->persist($admin);
        $em->flush();

        $output->writeln('email: '.$input->getArgument('email'));
        $output->writeln('Password: '.$input->getArgument('password'));

        return 0;
    }
}

