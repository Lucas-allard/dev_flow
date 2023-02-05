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
     * @param UserRepository $userRepository
     * @param FirestoreService $firestoreService
     */
    public function __construct(
        private UserRepository   $userRepository,
        private FirestoreService $firestoreService,
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
        $user['id'] = $this->getUser()->getId();
        $user['email'] = $this->getUser()->getEmail();

        return $this->render('chat/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/send', name: 'send')]
    #[IsGranted('ROLE_USER')]
    public function send(
        Request                $request,
    ): Response
    {
        $messageData = json_decode($request->getContent(), true);

        $this->cleanInput($messageData["message"]);

//            $user
//                ->setPoints($user->getPoints() + 2)
//                ->setChatMessageCount($user->getChatMessageCount() + 1);
//
//            $this->userRepository->save($user);

        $this->firestoreService->addDocument(
            $messageData["collection"],
            [
                "message" => $messageData["message"],
                "fullName" => $messageData["user"]["fullName"],
                "profilPicture" => $messageData["user"]["profilPicture"],
                "timestamp" => new FirestoreTimestamp(),
            ]);


        if ($this->firestoreService->isSuccess()) {
            return new Response('', Response::HTTP_CREATED);
        } else {
            return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[
        Route('/send/private', name: 'send_private')]
    #[IsGranted('ROLE_USER')]
    public function sendPrivateMessage(
        Request $request,
    ): Response
    {
        $messageData = json_decode($request->getContent(), true);

        $messageData = $this->cleanInput($messageData["message"]);

        $this->firestoreService->addDocument(
            $messageData["collection"],
            [
                "from" => $messageData["from"],
                "to" => $messageData["to"],
                "participants" => $messageData["participants"],
                "message" => $messageData["message"],
                "timestamp" => new FirestoreTimestamp(),
            ]);

        if ($this->firestoreService->isSuccess()) {
            return new Response('', Response::HTTP_CREATED);
        } else {
            return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public
    function cleanInput($input): string
    {
        $input = strip_tags($input, '<br>,<img>');
        $input = preg_replace('#<img(.*?)src="(.*?)"(.*?)>#', '<img src="$2" alt="gif">', $input);
        return htmlentities($input);
    }
}
