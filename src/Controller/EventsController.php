<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventParticipant;
use App\Form\EventEditType;
use App\Form\EventType;
use App\Repository\EventLogistocRepository;
use App\Repository\EventParticipantRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    private $EventRepository;
    private $entityManager;
    private $EventLogistocRepository;
    private $UserRepository;
    private $EventParticipantRepository;

    public function __construct(EventRepository $EventRepository, EntityManagerInterface $entityManager, EventLogistocRepository $EventLogistocRepository, UserRepository $UserRepository, EventParticipantRepository $EventParticipantRepository)
    {
        $this->EventRepository = $EventRepository;
        $this->entityManager = $entityManager;
        $this->EventLogistocRepository = $EventLogistocRepository;
        $this->EventLogistocRepository = $UserRepository;
        $this->EventParticipantRepository = $EventParticipantRepository;
    }

    /**
     * @Route("/event", name="app_event")
     */
    public function index(): Response
    {
        $Events = $this->EventRepository->findBy(["is_valid" => 1, "is_archive" => 0], ['id' => 'DESC']);
        return $this->render('events/index.html.twig', [
            'events' => $Events,
        ]);
    }

    /**
     * @Route("/event/new", name="app_event_new")
     */
    public function new(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event->setIsValid(0);
            $event->setUser($this->getUser());
            $this->entityManager->persist($event);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_event');
        }
        return $this->render('event/new.html.twig', [
            'eventForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/{id}", name="app_event_show")
     */
    public function show($id)
    {
        $event = $this->EventRepository->find($id);
        return $this->render('events/show.html.twig', [
            'event' => $event
        ]);
    }

    /**
     * @Route("/event/edit/{id}", name="app_event_edit")
     */
    public function edit(Request $request, $id)
    {
        $event = $this->EventRepository->find($id);
        $form = $this->createForm(EventEditType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_app_event');
        }
        return $this->render('event/new.html.twig', [
            'eventForm' => $form->createView(),
            'event' => $event
        ]);
    }

    /**
     * @Route("/event/participate/{id}", name="app_event_participate")
     */
    public function participate($id)
    {
        $event = $this->EventRepository->find($id);
        $participation = new EventParticipant();
        $participation->setEvent($event);
        $participation->setUser($this->getUser());
        $this->entityManager->persist($participation);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_event');
    }

    /**
     * @Route("/event/Noparticipate/{id}", name="app_event_noparticipate")
     */
    public function Noparticipate($id)
    {
        $participation = $this->EventParticipantRepository->find($id);
        $this->entityManager->remove($participation);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_event');
    }
}
