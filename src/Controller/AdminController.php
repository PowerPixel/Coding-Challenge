<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }
    /**
     * @Route("/users_approval",name="users_approval")
     */
    public function usersApproval(): Response
    {
        $waitingUsers = $this->getDoctrine()->getRepository(User::class)->findByRoles("[\"ROLE_NEW_USER\"]");
        return $this->render('admin/users_approval.html.twig', [
            "users" => $waitingUsers
        ]);
    }
    /**
     * @Route("/user_approved/{id}",name="user_approved")
     * @IsGranted("ROLE_ADMIN")
     */
    public function userApproved(int $id): Response
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->find($id);
        $user->setRoles(array("ROLE_USER"));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("users_approval");
    }
    /**
     * @Route("/user_refused/{id}",name="user_refused")
     * @IsGranted("ROLE_ADMIN")
     */
    public function userRefused(int $id): Response
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute("users_approval");
    }
}
