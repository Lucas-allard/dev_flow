<?php

namespace App\Controller;


use App\Normalizer\UserNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/dashboard', name: 'dashboard_')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    const SUCCESS_RESPONSE = 'success';

    const ERROR_RESPONSE = 'error';
    const UPDATED_PROFILE_RESPONSE = 'Profil mis à jour avec succès';
    const UPDATE_PROFILE_FAILED_RESPONSE = 'La mise à jour du profil a échoué';

    public function __construct(
        private UserNormalizer            $normalizer,
        private CsrfTokenManagerInterface $csrfTokenManager,
        private TokenStorageInterface     $tokenStorage,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/', name: 'index')]
    public function index(): Response
    {

        $csrfToken = $this->csrfTokenManager->getToken("dashboard");
        $authenticationToken = $this->getAuthToken();

        $user = $this->normalizer->normalize($this->getUser());

        $user['csrfToken'] = $csrfToken->getValue();
        $user['authenticationToken'] = $authenticationToken;

        dd($this->tokenStorage->getToken());

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/update', name: 'update_profile')]
    public function updateProfile(Request $request): Response
    {

        $updateData = json_decode($request->getContent(), true);

        dd($updateData);

        return new Response(self::UPDATED_PROFILE_RESPONSE, Response::HTTP_OK);

    }


    public function getAuthToken()
    {
        return $this->tokenStorage->getToken()->getCredentials();
    }
}
