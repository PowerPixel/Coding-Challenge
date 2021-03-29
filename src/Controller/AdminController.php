<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\Exercise;
use App\Entity\ExerciseState;
use App\Form\AdminRegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
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
     *  Controls the route to see users waiting for approval user in the admin panel.
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
     */
    public function userRegistrationPanel(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $user->setRoles(array("ROLE_USER"));
        $form = $this->createForm(AdminRegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('username')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            unset($form);
            $user = new User();
            $user->setRoles(array("ROLE_USER"));
            $form = $this->createForm(AdminRegistrationFormType::class, $user);
            $this->addFlash('success', "L'utilisateur à été crée avec succés !");
        }

        return $this->render('admin/admin_user_registration.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * Controls the route to the exercise approval panel.
     * @Route("/exercises/{page?1}",name="exercises")
     */
    public function exercisesViewPanel(int $page): Response
    {
        $searchTerm = ['searchTerm' => "",];
        $searchFormBuilder = $this->createFormBuilder($searchTerm);
        $searchFormBuilder->add('searchTerm', SearchType::class, [
            'required' => false,
            'label' => "Recherche",
        ])
            ->add('search', SubmitType::class, [
                'label' => "Rechercher"
            ]);
        $form = $searchFormBuilder->getForm();
        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->getData();
        }
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercises = $exercisesRepo->findExercisesByPageWithSearchCriteria($page, 10, $searchTerm['searchTerm']);
        $isLastPage = ($page === intval($exercises['numberOfPages']));
        return $this->render('admin/exercises_manager_panel.html.twig', [
            'exercises' => $exercises['results'],
            'isLastPage' => $isLastPage,
            'form' => $form->createView()
        ]);
    }
    /**
     * Controls the view of an exercise.
     * @param integer $id The id of the exercise to view.
     * @Route("/exercises/view/{id}",name="exercise_view")
     */
    public function exerciseView(int $id): Response
    {
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercise = $exercisesRepo->find($id);
        $pathToExercise = $exercise->getFolderPath();
        $inputFiles = glob($pathToExercise . '/input*');
        $outputFiles = glob($pathToExercise . '/output*');
        $inputContents = array();
        $outputContents = array();
        foreach ($inputFiles as $file) {
            $content = file_get_contents($file);
            $inputContents[] = $content;
        }
        foreach ($outputFiles as $file) {
            $content = file_get_contents($file);
            $outputContents[] = $content;
        }

        return $this->render('admin/exercise_view.html.twig', [
            'outputs' => $outputContents,
            'inputs' => $inputContents,
            'name' => $exercise->getName()
        ]);
    }

    /**
     * The controller for the users managment panel route.
     *
     * @param integer $page The page of users to display.
     * @return void
     * @Route("/users_managment/{page?1}",name="users_managment")
     */
    public function usersControlPanel(int $page){
        $usersRepo = $this->getDoctrine()->getRepository(User::class);
        $users = $usersRepo->findUsersByPage($page,10);
        $isLastPage = ($page == $users['numberOfPages']);
        return $this->render("admin/admin_users_view.html.twig",
        [
            'users' => $users['results'],
            'isLastPage' => $isLastPage
        ]);
    }

    /**
     * @Route("/exercises_approval", name="exercises_approval")
     */
    public function exercisesApprovalPanel(): Response
    {
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercises = $exercisesRepo->findBy([
            'state' => 1,
        ]);
        return $this->render("admin/admin_exercises_approval_view.html.twig",
        [
            'exercises' => $exercises
        ]);
    }

    /**
     * @Route("/exercises_approval/{id}", name="individual_exercises_approval")
     */
    public function exercisesApprovalPage(int $id): Response
    {
        $exercisesRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercise = $exercisesRepo->find($id);
        $exerciseName = str_replace(' ', '',$exercise->getName());

        $inputDescription = file_get_contents(Exercise::$PATH_TO_EXERCISES_FOLDER . "/" . $exerciseName . "/inputDescription.txt");
        $outputDescription = file_get_contents(Exercise::$PATH_TO_EXERCISES_FOLDER . "/" . $exerciseName . "/outputDescription.txt");

        $pathToExercise = $exercise->getFolderPath();
        $inputFiles = glob($pathToExercise . '/input[0-9]*.txt');
        $outputFiles = glob($pathToExercise . '/output[0-9]*.txt');
        $inputContents = array();
        $outputContents = array();
        foreach ($inputFiles as $file) {
            $content = file_get_contents($file);
            $inputContents[] = $content;
        }
        foreach ($outputFiles as $file) {
            $content = file_get_contents($file);
            $outputContents[] = $content;
        }
        return $this->render("admin/admin_exercises_approval_view_individual.html.twig",[
            'exercise' => $exercise,
            'inputDescription' => $inputDescription,
            'outputDescription' => $outputDescription,
            'inputs' => $inputContents,
            'outputs' => $outputContents
        ]);
    }

    /**
     * @Route("/exercises_approval/{id}/validate", name="exercises_approval_validate")
     */
    public function exercisesApprovalValidation(int $id): Response
    {
        $exerciseRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $exercise = $exerciseRepo->find($id);
        $stateRepo = $this->getDoctrine()->getRepository(ExerciseState::class);
        $state = $stateRepo->find(2);
        $exercise->setState($state);

        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute("exercises_approval");
    }

    /**
     * @Route("/exercises_approval/{id}/denied", name="exercises_approval_denied")
     */
    public function exercisesApprovalDenial(Request $req, int $id, NotifierInterface $notifier): Response
    {
        $formBuilder = $this->createFormBuilder();
        $form = $formBuilder->add('remarks',TextareaType::class,[
            'label' => "Raison du refus"
        ])
        ->add("submit",SubmitType::class,[
            'label' => 'Refuser et notifier'
        ])
        ->getForm();
        $entityManager = $this->getDoctrine()->getManager();
        $exerciseRepo = $this->getDoctrine()->getRepository(Exercise::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $exercise = $exerciseRepo->find($id);
            $exerciseName = $exercise->getName();
            $exerciseCreator = $exercise->getCreator();
            $reason = $form->get('remarks')->getData();
            $notification = (new Notification('Refus de votre exercice '. $exerciseName, ['email']))
            ->content("Votre exercice " . $exerciseName . "a été refusé. \n Raison : \n" . $reason);
            $recipient = new Recipient($exerciseCreator->getEmail());
            $notifier->send($notification,$recipient);
            $exerciseFolderName = str_replace(' ', '',$exerciseName);;
            $exerciseFolderPath = Exercise::$PATH_TO_EXERCISES_FOLDER . '/' . $exerciseFolderName;
            $files = array_diff(scandir($exerciseFolderPath),Array('.','..'));
            foreach($files as $file){
                unlink($exerciseFolderPath . '/' . $file);
            }
            rmdir($exerciseFolderPath);
            $entityManager->remove($exercise);
            $entityManager->flush();

            return $this->redirectToRoute("exercises_approval");
        }
        return $this->render(
            'admin/admin_exercise_denial_form.html.twig',[
                'form' => $form->createView(),
            ]
        );
    }
}
