<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Demand;
use App\Entity\Ticket;
use App\Entity\User;
use App\Form\AdminDemandType;
use App\Form\DemandType;
use App\Form\Ticket2Type;
use App\Repository\DemandRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demand")
 */
class DemandController extends AbstractController
{
    /**
     * @Route("/", name="demand_index", methods={"GET"})
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(DemandRepository $demandRepository): Response
    {
        return $this->render('demand/index.html.twig', [
            'demands' => $demandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="demand_new", methods={"GET","POST"})
     *
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $demand = new Demand();
        $form = $this->createForm(DemandType::class, $demand);
        $form->handleRequest($request);



        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser()->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $demand->setStatus('En attente');
            $demand->setUser($user);
            $demand->setViews(false);
            $demand->setUpdatedAt(new DateTime());
            $demand->setcreatedAt(new DateTime());
            $entityManager->persist($demand);
            $entityManager->flush();

            return $this->redirectToRoute('email');
        }

        return $this->render('demand/new.html.twig', [
            'demand' => $demand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demand_show", methods={"GET"})
     */
    public function show(Demand $demand): Response
    {
        $tickets = $this->getDoctrine()
            ->getRepository(Ticket::class)
            ->findBy(['demand' => $demand->getId()]);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['id' => $demand->getUser()]);

        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findBy(['id' => $user[0]->getCustomer()->getId()]);

        return $this->render('demand/show.html.twig', [
            'demand' => $demand,
            'customer' => $customer[0],
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demand_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Demand $demand): Response
    {
        $form = $this->createForm(DemandType::class, $demand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $demand->setUpdatedAt(new DateTime());
            $entityManager->persist($demand);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('demand/edit.html.twig', [
            'demand' => $demand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/admin_edit", name="demand_admin_edit", methods={"GET","POST"})
     */
    public function adminEdit(Request $request, Demand $demand): Response
    {
        $form = $this->createForm(AdminDemandType::class, $demand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $demand->setViews(true);
            $entityManager->persist($demand);
            $entityManager->flush();

            return $this->redirectToRoute('demand_index');
        }

        return $this->render('demand/edit.html.twig', [
            'demand' => $demand,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demand_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Demand $demand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demand_index');
    }

    /**
     * @Route("/{id}/ticket", name="ticket_new_from_demand")
     */
    public function newTicket(Request $request, int $id):Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(Ticket2Type::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demand = $this->getDoctrine()
                ->getRepository(Demand::class)
                ->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $ticket->setDemand($demand);
            $ticket->setCreatedAt(new DateTime());
            $ticket->setUpdatedAt(new DateTime());
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

}
