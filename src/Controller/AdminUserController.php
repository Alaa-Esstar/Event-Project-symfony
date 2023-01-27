<?php

namespace App\Controller;

use App\Entity\EventParticipant;
use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\EventParticipantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminUserController extends AbstractController
{
    private $UserRepository;
    private $EntityManager;
    private $EventParticipantRepository;

    public function __construct(UserRepository $UserRepository, EntityManagerInterface $EntityManager, EventParticipantRepository $EventParticipantRepository)
    {
        $this->EntityManager = $EntityManager;
        $this->UserRepository = $UserRepository;
        $this->EventParticipantRepository = $EventParticipantRepository;
    }

    /**
     * @Route("/admin/user", name="app_admin_user")
     */
    public function index(): Response
    {
        $users = $this->UserRepository->findAll();
        return $this->render('admin_user/index.html.twig', [
            "users" => $users
        ]);
    }

    /**
     * @Route("/admin/user/new", name="app_admin_user_new")
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $user->setPassword(
                    $userPasswordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }
            $this->EntityManager->persist($user);
            $this->EntityManager->flush();
            return $this->redirectToRoute('app_admin_user');
        }
        return $this->render('admin_user/profile.html.twig', [
            "user" => $user,
            'userForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/user/{id}", name="app_admin_user_edit")
     */
    public function edit(Request $request, $id, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user = $this->UserRepository->find($id);
        $participants = $this->EventParticipantRepository->findBy(['user' => $user]);
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $user->setPassword(
                    $userPasswordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }
            $this->EntityManager->persist($user);
            $this->EntityManager->flush();
            return $this->redirectToRoute('app_admin_user');
        }
        return $this->render('admin_user/profile.html.twig', [
            "user" => $user,
            "participants" => $participants,
            'userForm' => $form->createView()
        ]);
    }
}
