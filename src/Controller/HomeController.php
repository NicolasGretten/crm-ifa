<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Customer;
use App\Entity\Demand;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        if($this->getUser() !== null) {
            $id = $this->getUser()->getId();

            $companies = $this->getDoctrine()
                ->getRepository(Company::class)
                ->findAll();

            $usersSinceJanuary = $this->getDoctrine()
                ->getRepository(User::class)
                ->userRegisteredSinceJanuary();

            $customer = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findAll();

            $allDemands = $this->getDoctrine()
                ->getRepository(Demand::class)
                ->findAll();

            $demands = $this->getDoctrine()
                ->getRepository(Demand::class)
                ->findBy(['user' => $id]);

            $demandNotReviewed = $this->getDoctrine()
                ->getRepository(Demand::class)
                ->findBy(['views' => false]);

            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
                'demands' => $demands,
                'demand_not_reviewed' => $demandNotReviewed,
                'companies' => $companies,
                'customer' => $customer,
                'all_demands' => $allDemands,
                'user_since_january' => $usersSinceJanuary,
            ]);
        }

        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/email", name="email")
     */
    public function sendEmail(MailerInterface $mailer)
    {

        $admin = $this->getDoctrine()
            ->getRepository(User::class)
            ->findUsersByRole('ROLE_ADMIN');

        $email = (new Email())
            ->to($admin[0]->getEmail())
            ->subject('A new demand have been added')
            ->text('A new demand have been added by a user, go check-it !');

        $mailer->send($email);
        return $this->redirectToRoute('home');
    }
}
