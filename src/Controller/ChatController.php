<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    #[Route('/chat', name: 'chat')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('connect_google_start');
        }

        $userData = [
            "fullname" => $this->getUser()->getFullName(),
            "id" => $this->getUser()->getGoogleId(),
            "profilPicture" => $this->getUser()->getProfilPicture(),
            "roles" => $this->getUser()->getRoles(),
        ];

        return $this->render('chat/index.html.twig', [
            'userData' => json_encode($userData),
        ]);
    }
}
