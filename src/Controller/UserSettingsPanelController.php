<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSettingsPanelController extends AbstractController
{
    /**
     * @Route("/settings", name="user_settings_panel")
     */
    public function index(): Response
    {
        return $this->render('user_settings_panel/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/settings/password", name="user_settings_panel_password")
     */
    public function passwordChange(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

    	$form = $this->createForm(ChangePasswordFormType::class, $user);

    	$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
                $user->setPassword($newEncodedPassword);
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Votre mot de passe à bien été changé !');
                return $this->redirectToRoute('user_settings_panel_password');
            } else {
                $this->addFlash('error','Ancien mot de passe incorrect');
            }
        }
    	
        return $this->render('user_settings_panel/user_settings_panel_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
