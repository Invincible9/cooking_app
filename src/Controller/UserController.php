<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\CourseService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register')]
    public function register(
        Request $request,
        UserService $userService,
        UserAuthenticatorInterface $authenticator,
        LoginFormAuthenticator $formAuthenticator
    ): Response {

        if($this->getUser()) {
            return $this->redirectToRoute('home_index');
        }

        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $userService->register($user, $plainPassword);
            return $authenticator->authenticateUser($user, $formAuthenticator, $request);
        }

        return $this->render('users/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile', name: 'user_profile')]
    public function profile(UserService $userService, CourseService $courseAccessService): Response
    {
        $currentUser = $userService->getCurrentUser();

        return $this->render('users/profile.html.twig', [
            'user' => $currentUser,
        ]);
    }

}