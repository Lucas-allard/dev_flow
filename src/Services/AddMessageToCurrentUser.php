<?php

namespace App\Services;

use App\Entity\ChatMessage;
use App\Entity\User;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddMessageToCurrentUser
{
    public function sendMessage(
        Request               $request,
        UserRepository        $userRepository,
        ChatMessageRepository $chatMessageRepository,
    ): void
    {
        if ($request->request->get("content")) {
            $chatMessage = new ChatMessage();

            $user = $userRepository->find(['id' => $request->request->get("id")]);

            $chatMessage->setContent($request->request->get("content"))
                ->setUser($user)
                ->setTimestamp(new DateTime());

            $chatMessageRepository->save($chatMessage, true);
        };
    }
}