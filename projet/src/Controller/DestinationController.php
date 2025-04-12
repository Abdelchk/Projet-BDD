<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Repository\DestinationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;

class DestinationController extends AbstractController
{
    #[Route('/destinations', name: 'app_destinations')]
    public function index(DestinationRepository $destinationRepository): Response
    {
        $destinations = $destinationRepository->findAll();
        return $this->render('destination/index.html.twig', [
            'destinations' =>  $destinations
        ]);
    }


    #[Route('/destinations/{id}/toggle-favorite', name: 'app_toggle_favorite', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function toggleFavorite(
        int $id,
        EntityManagerInterface $em,
        DestinationRepository $destinationRepository
    ): JsonResponse {
        $destination = $destinationRepository->find($id);
        if (!$destination) {
            return $this->json(['error' => 'Destination not found'], 404);
        }

        $user = $this->getUser();
        $profil = $user->getProfil();

        if ($profil->hasPreference($id)) {
            $profil->removePreference($id);
        } else {
            $profil->addPreference($id);
        }

        $em->persist($profil);
        $em->flush();

        return $this->json(['success' => true, 'favorite' => $profil->hasPreference($id)]);
    }
}
