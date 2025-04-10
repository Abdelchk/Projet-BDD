<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Core\Encoder\PasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Password\PasswordHasherInterface;



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
    public function register(Request $request, PasswordHasherInterface $passwordHasher, UtilisateurRepository $userRepository, Security $security): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $plainPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hash($plainPassword);
            $user->setPassword($hashedPassword);

            // Enregistrement de l'utilisateur
            $userRepository->save($user, true);

            // Connexion immédiate de l'utilisateur après l'enregistrement
            // Créer un token pour l'utilisateur et se connecter
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
            $security->getTokenStorage()->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('app_home'); // Redirige vers la page d'accueil ou autre
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
