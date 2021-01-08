<?php

namespace App\Controller;

use App\Entity\Demand;
use App\Entity\Ticket;
use App\Form\Ticket2Type;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ticket")
 */
class TicketController extends AbstractController
{
    /**
     * @Route("/", name="ticket_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     * @param TicketRepository $ticketRepository
     * @return Response
     */
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ticket_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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

    /**
     * @Route("/{id}", name="ticket_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     * @param Ticket $ticket
     * @return Response
     */
    public function show(Ticket $ticket): Response
    {

        $demand = $this->getDoctrine()
            ->getRepository(Demand::class)
            ->findby(['id' => $ticket->getDemand()]);

        if ($demand == false) {
            $demand[0] = false;
        }

        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
            'demand' => $demand[0]
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ticket_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function edit(Request $request, Ticket $ticket): Response
    {
        $form = $this->createForm(Ticket2Type::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ticket->setUpdatedAt(new DateTime());
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param Ticket $ticket
     * @return Response
     */
    public function delete(Request $request, Ticket $ticket): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ticket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ticket_index');
    }
}
