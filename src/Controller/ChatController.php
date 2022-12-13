<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ChatController extends AbstractController
{
    #[Route('/chat', name: 'chat')]
    public function index(UserInterface $user): Response
    {
        $userData = [
            "fullname" => $user->getFullName(),
            "id" => $user->getGoogleId(),
            "profilPicture" => $user->getProfilPicture(),
        ];

        return $this->render('chat/index.html.twig', [
            'userData' => json_encode($userData),
        ]);
    }
}
