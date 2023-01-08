<?php

namespace App\Services;

use App\Entity\ChatMessage;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use DateTime;
use MrShan0\PHPFirestore\Fields\FirestoreTimestamp;

class AddMessageToCurrentUser
{
    public function __construct()
    {
    }

    public function sendMessage(
        array                  $messageData,
        UserRepository         $userRepository,
        ?ChatMessageRepository $chatMessageRepository = null,
    ): void
    {
        if ($chatMessageRepository) {
            $user = $userRepository->find(["id" => $messageData["id"]]);

            $chatMessage = new ChatMessage();
            $chatMessage->setContent($messageData["message"])
                ->setUser($user)
                ->setTimestamp(new DateTime());
            $chatMessageRepository->save($chatMessage, true);
        }
    }
}