<?php

namespace App\EventListener;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LoginListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event,): void
    {
        // Récupération de l'utilisateur authentifié
        $user = $event->getAuthenticationToken()->getUser();

        if ($user) {
            $user->setIsLogged(true)
                ->setLastActivity(new DateTime());

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }


}
