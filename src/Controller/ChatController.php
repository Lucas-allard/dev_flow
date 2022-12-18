<?php

namespace App\Controller;

use App\Entity\ChatMessage;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use App\Services\AddMessageToCurrentUser;
use DateTime;
use phpDocumentor\Reflection\Types\This;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ChatController extends AbstractController
{

    /**
     * @param CsrfTokenManagerInterface $csrfTokenManager
     */
    public function __construct(private CsrfTokenManagerInterface $csrfTokenManager)
    {
    }

    /**
     * @param Request $request
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param SessionInterface $session
     * @return Response
     */
    #[Route('/chat', name: 'chat')]
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

        return $this->render('chat/index.html.twig', [
            'userData' => json_encode($userData),
        ]);
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param ChatMessageRepository $chatMessageRepository
     * @param AddMessageToCurrentUser $service
     * @param TokenStorageInterface $tokenStorage
     * @return Response
     */
    #[Route('/chat/send', name: 'chat_send')]
    public function send(
        Request                 $request,
        UserRepository          $userRepository,
        ChatMessageRepository   $chatMessageRepository,
        AddMessageToCurrentUser $service,
        TokenStorageInterface   $tokenStorage
    ): Response
    {
        $submitedToken = urldecode($request->request->get("csrfToken"));


        if (
            $request->request->get("content")
            && $request->request->get("id")
            && $request->request->get("timestamp")
            && !$this->csrfTokenManager->isTokenValid(new CsrfToken('chat', $submitedToken))
        ) {
            $service->sendMessage($request, $userRepository, $chatMessageRepository);

            return (new Response())->setStatusCode("201", "Message ajouté à l'utilisateur courrant avec succès");
        } else {
            return (new Response())->setStatusCode("500", "Erreur serveur");
        }

    }
}
