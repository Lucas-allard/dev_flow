<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JwtController extends AbstractController
{
    /**
     * @Route("/api/jwt/create", name="create_jwt")
     */
    public function createToken(Request $request, UserRepository $userRepository, JWTTokenManagerInterface $jwtManager)
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $id = $data['id'];


        if (!$email) {
            return new JsonResponse([
                'error' => 'Email not found in request'
            ], 400);
        }

        if (!$id) {
            return new JsonResponse([
                'error' => 'Id not found in request'
            ], 400);
        }

        $user = $userRepository->findOneBy([
            'email' => $email,
            'id' => $id
        ]);

        if (!$user) {
            return new JsonResponse([
                'error' => 'User not found'
            ], 404);
        }

        $token = $jwtManager->create($user);


        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
