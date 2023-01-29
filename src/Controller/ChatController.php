<?php

namespace App\Controller;

use App\Entity\ChatMessage;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use App\Normalizer\UserNormalizer;
use App\Services\AddMessageToCurrentUser;
use App\Services\FirestoreService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use MrShan0\PHPFirestore\Fields\FirestoreTimestamp;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;


#[Route('/chat', name: 'chat_')]
class ChatController extends AbstractController
{

    /**
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UserRepository $userRepository
     * @param FirestoreService $firestoreService
     */
    public function __construct(
        private CsrfTokenManagerInterface $csrfTokenManager,
        private UserRepository            $userRepository,
        private FirestoreService          $firestoreService,
        private UserNormalizer            $normalizer,
    )
    {
    }

    /**
     * @return Response
     * @throws ExceptionInterface
     */
    #[Route('/', name: 'index')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $csrfToken = $this->csrfTokenManager->getToken("send");

        $user = $this->normalizer->normalize($this->getUser());

        $user['csrfToken'] = $csrfToken->getValue();

        $users = $this->normalizer->normalize($this->userRepository->findAll());

        return $this->render('chat/index.html.twig', [
            'userData' => $user,
            'users' => $users
        ]);
    }

    /**
     * @param Request $request
     * @param ChatMessageRepository $chatMessageRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/send', name: 'send')]
    public function send(
        Request                $request,
        ChatMessageRepository  $chatMessageRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $messageData = json_decode($request->getContent(), true);

        $messageData['message'] = strip_tags($messageData['message'], '<br>,<img>');

        $messageData['message'] = preg_replace('#<img(.*?)src="(.*?)"(.*?)>#', '<img src="$2" alt="gif">', $messageData['message']);

        $messageData['message'] = htmlentities($messageData['message']);

        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('chat', $messageData["user"]["csrfToken"]))) {

            $user = $this->userRepository->find(["id" => $messageData["id"]]);

            $chatMessage = new ChatMessage();
            $chatMessage->setContent($messageData["message"])
                ->setUser($user)
                ->setTimestamp(new DateTime());

            $user
                ->setPoints($user->getPoints() + 2)
                ->setChatMessageCount($user->getChatMessageCount() + 1);

            $chatMessageRepository->save($chatMessage);
            $this->userRepository->save($user);
            $this->firestoreService->addDocument(
                $messageData["collection"],
                [
                    "message" => $messageData["message"],
                    "fullName" => $messageData["user"]["fullName"],
                    "profilPicture" => $messageData["user"]["profilPicture"],
                    "timestamp" => new FirestoreTimestamp(),
                ]);


            $entityManager->flush();


            return new Response('', Response::HTTP_CREATED);
        } else {
            return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/send/private', name: 'send_private')]
    public function sendPrivateMessage(
        Request $request,
    ): Response
    {
        $messageData = json_decode($request->getContent(), true);

        $messageData['message'] = strip_tags($messageData['message'], '<br>,<img>');

        $messageData['message'] = preg_replace('#<img(.*?)src="(.*?)"(.*?)>#', '<img src="$2" alt="gif">', $messageData['message']);

        $messageData['message'] = htmlentities($messageData['message']);

        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('chat', $messageData["user"]["csrfToken"]))) {

            $this->firestoreService->addDocument(
                $messageData["collection"],
                [
                    "from" => $messageData["from"],
                    "to" => $messageData["to"],
                    "participants" => $messageData["participants"],
                    "message" => $messageData["message"],
                    "timestamp" => new FirestoreTimestamp(),
                ]);

            return new Response('', Response::HTTP_CREATED);
        } else {
            return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
