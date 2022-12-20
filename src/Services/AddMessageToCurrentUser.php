<?php

namespace App\Services;

use App\Entity\ChatMessage;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use DateTime;
use MrShan0\PHPFirestore\Fields\FirestoreTimestamp;

class AddMessageToCurrentUser
{
    public function __construct(private FirestoreService $firestoreService)
    {
    }

    public function sendMessage(
        array                 $messageData,
        UserRepository        $userRepository,
        ChatMessageRepository $chatMessageRepository,
    ): void
    {
        $chatMessage = new ChatMessage();

        $user = $userRepository->find(["id" => $messageData["id"]]);

        $chatMessage->setContent($messageData["message"])
            ->setUser($user)
            ->setTimestamp(new DateTime());

        $chatMessageRepository->save($chatMessage, true);

        $this->firestoreService->addDocument(
            $messageData["collection"],
            [
                "message" => $messageData["message"],
                "fullname" => $messageData["user"]["fullname"],
                "profilPicture" => $messageData["user"]["profilPicture"],
                "timestamp" => new FirestoreTimestamp(),
            ]);
    }
}