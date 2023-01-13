<?php

namespace App\Controller;

use App\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class ManagerController extends AbstractController
{
    /**
     * @param Request $request
     * @param string $name
     * @param object $entity
     * @return bool
     */
    protected function checkToken(Request $request, string $name, object $entity): bool
    {
        $token = $request->query->get("token");

        return $this->isCsrfTokenValid($name . $entity->getId(), $token);
    }
}