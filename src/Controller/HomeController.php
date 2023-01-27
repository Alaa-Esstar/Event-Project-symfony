<?php

namespace App\Controller;

use App\Repository\EventParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;

class HomeController extends AbstractController
{
    private $EventRepository;
    private $EventParticipantRepository;

    public function __construct(EventRepository $EventRepository, EventParticipantRepository $EventParticipantRepository)
    {
        $this->EventRepository = $EventRepository;
        $this->EventParticipantRepository = $EventParticipantRepository;
    }

    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $last_events = $this->EventRepository->findBy(["is_valid" => 1, "is_archive" => 0], ['id' => 'DESC'], 3, 0);
        return $this->render('home/index.html.twig', [
            'last_events' => $last_events
        ]);
    }
}
