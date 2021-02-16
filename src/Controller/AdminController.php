<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\AdminRegistrationFormType;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }
    /**
     *  Controls the route to see users waiting for approval user in the admin panel.
     * @Route("/users_approval",name="users_approval")
     * @IsGranted("ROLE_ADMIN")
     */
    public function usersApproval(): Response
    {
        $waitingUsers = $this->getDoctrine()->getRepository(User::class)->findByRoles("[\"ROLE_NEW_USER\"]");
        return $this->render('admin/users_approval.html.twig', [
            "users" => $waitingUsers
        ]);
    }
    /**
     * Controls the route to accept a certain user in the admin panel.
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
     * Controls the route to refuse a certain user in the admin panel.
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
    /**
     * Controls the route to the bulk registration panel.
     * @Route("/user_registration",name="admin_user_registration")
     * @IsGranted("ROLE_ADMIN")
     */
    public function userRegistration(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $user->setRoles(array("ROLE_USER"));
        $form = $this->createForm(AdminRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('username')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('admin/admin_user_registration.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

   
}
