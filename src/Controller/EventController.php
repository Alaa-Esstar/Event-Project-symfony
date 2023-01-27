<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventLogistoc;
use App\Form\EventEditType;
use App\Form\EventType;
use App\Repository\EventLogistocRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin", name="admin_")
 * @isGranted("ROLE_ADMIN")
 */
class EventController extends AbstractController
{
    private $EventRepository;
    private $entityManager;
    private $EventLogistocRepository;

    public function __construct(EventRepository $EventRepository, EntityManagerInterface $entityManager, EventLogistocRepository $EventLogistocRepository)
    {
        $this->EventRepository = $EventRepository;
        $this->entityManager = $entityManager;
        $this->EventLogistocRepository = $EventLogistocRepository;
    }

    /**
     * @Route("/event", name="app_event")
     */
    public function index(): Response
    {
        $Events = $this->EventRepository->findAll();
        return $this->render('event/index.html.twig', [
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

            return $this->redirectToRoute('admin_app_event');
        }
        return $this->render('event/new.html.twig', [
            'eventForm' => $form->createView(),
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
     * @Route("/event/delet/{id}", name="app_event_delet")
     */
    public function delet($id)
    {
        $event = $this->EventRepository->find($id);
        $this->entityManager->remove($event);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_app_event');
    }


    /**
     * @Route("/event/logs/new", name="app_event_add_log")
     */
    public function newLog(Request $request)
    {
        $event = $this->EventRepository->find($request->get("id_event"));
        $log = new EventLogistoc();
        $log->setEvent($event);
        $log->setName($request->get("nom"));
        $log->setDescription($request->get("desc"));
        $this->entityManager->persist($log);
        $this->entityManager->flush();
        return new JsonResponse("sucess", 200);
    }

    /**
     * @Route("/event/logs/edit", name="app_event_edit_log")
     */
    public function editLog(Request $request)
    {
        $log = $this->EventLogistocRepository->find($request->get("id_log"));
        $log->setName($request->get("nom"));
        $log->setDescription($request->get("desc"));
        $this->entityManager->persist($log);
        $this->entityManager->flush();
        return new JsonResponse("sucess", 200);
    }

    /**
     * @Route("/event/logs/delet/{id}", name="app_event_delet_log")
     */
    public function deletLog($id)
    {
        $log = $this->EventLogistocRepository->find($id);
        $id_event = $log->getEvent()->getId();
        $this->entityManager->remove($log);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_app_event_edit', ['id' => $id_event]);
    }
}
