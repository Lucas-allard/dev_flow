<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class PostImageController
{
    public function __invoke(Request $request): User
    {


        $user = $request->attributes->get('data');

        if (!($user instanceof User)) {
            throw new \RuntimeException('User not found');
        }

        $file = $request->files->get('file');

        $user->setImageFile($file);
        $user->setLastActivity(new \DateTime());
        return $user;
    }
}