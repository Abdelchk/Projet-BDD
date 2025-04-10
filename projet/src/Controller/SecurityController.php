<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\PasswordHasherInterface; // Corriger ici
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use App\Repository\UtilisateurRepository;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, PasswordHasherInterface $passwordHasher, UtilisateurRepository $userRepository): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $plainPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hash($plainPassword);  // Utilisation correcte de PasswordHasherInterface
            $user->setPassword($hashedPassword);

            // Enregistrement de l'utilisateur
            $userRepository->save($user, true);

            // Connexion immédiate de l'utilisateur après l'enregistrement
            $this->login($user);

            return $this->redirectToRoute('app_home'); // Redirige vers la page d'accueil ou autre
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
