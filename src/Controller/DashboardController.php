<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'dashboard_')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $user['id'] = $this->getUser()->getId();
        $user['email'] = $this->getUser()->getEmail();

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
        ]);
    }

}
