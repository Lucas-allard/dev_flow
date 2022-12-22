<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;

class IdleTimeoutRequestListener
{
    private $tokenStorage;
    private $logoutUrlGenerator;
    private $idleTimeout;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TokenStorageInterface  $tokenStorage,
        LogoutUrlGenerator     $logoutUrlGenerator,
        int                    $idleTimeout,
        EntityManagerInterface $entityManager,

    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->logoutUrlGenerator = $logoutUrlGenerator;
        $this->entityManager = $entityManager;
        $this->idleTimeout = $idleTimeout;
    }

    public function onKernelRequest(RequestEvent $event,)
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        // Vérifie si l'utilisateur est authentifié et s'il y a une session active
        if ($this->tokenStorage->getToken() && $session) {
            // Récupère la date de dernière activité de l'utilisateur
            $lastActivity = $session->get('_security.last_activity');

            // Vérifie si l'utilisateur est inactif depuis plus longtemps que la durée définie dans `session.cookie_lifetime`
            if ($lastActivity && (time() - $lastActivity > $this->idleTimeout)) {
                // Déconnecte l'utilisateur et redirige vers la route de déconnexion

                $user = $this->tokenStorage->getToken()->getUser();
                $user->setIsLogged(false);

                $this->entityManager->persist($user);
                $this->entityManager->flush($user);

                $this->tokenStorage->setToken(null);
                $session->invalidate();

                $response = new RedirectResponse("/login");
                $event->setResponse($response);
            } else {
                // Met à jour la date de dernière activité de l'utilisateur
                $session->set('_security.last_activity', time());
            }
        }
    }
}

