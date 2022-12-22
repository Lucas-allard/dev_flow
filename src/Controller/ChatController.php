<?php

namespace App\Controller;

use App\Repository\ChatMessageRepository;
use App\Repository\ConnectedUserRepository;
use App\Repository\UserRepository;
use App\Services\AddMessageToCurrentUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class ChatController extends AbstractController
{

    /**
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function __construct(
        private CsrfTokenManagerInterface $csrfTokenManager,
        private UserRepository            $userRepository,

    )
    {
    }

    /**
     * @return Response
     */
    #[Route('/chat', name: 'chat')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $csrfToken = $this->csrfTokenManager->getToken("send");

        $userData = [
            "fullname" => $this->getUser()->getFullName(),
            "id" => $this->getUser()->getId(),
            "profilPicture" => $this->getUser()->getProfilPicture(),
            "roles" => $this->getUser()->getRoles(),
            "csrfToken" => $csrfToken->getValue()
        ];

        $usersList = $this->userRepository->findAll();
        $users = [];

        foreach ($usersList as $user) {
            $users[] = [
                'fullname' => $user->getFullName(),
                'isConnected' => $user->isIsLogged()
            ];
        }

        return $this->render('chat/index.html.twig', [
            'userData' => json_encode($userData),
            'users' => json_encode($users)
        ]);
    }

    /**
     * @param Request $request
     * @param ChatMessageRepository $chatMessageRepository
     * @param AddMessageToCurrentUser $service
     * @return Response
     */
    #[Route('/chat/send', name: 'chat_send')]
    public function send(
        Request                 $request,
        ChatMessageRepository   $chatMessageRepository,
        AddMessageToCurrentUser $service,
    ): Response
    {
        $messageData = json_decode($request->getContent(), true);

        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('chat', $messageData["user"]["csrfToken"]))) {

            $service->sendMessage($messageData, $this->userRepository, $chatMessageRepository);

            return (new Response())->setStatusCode("201", "Created");
        } else {
            return (new Response())->setStatusCode("500", "Erreur serveur");
        }
    }
}
