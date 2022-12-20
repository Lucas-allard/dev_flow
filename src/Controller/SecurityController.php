<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController
{
    #[Route('/deconnexion', name: 'app_logout')]
    public function index()
    {
    }
}
