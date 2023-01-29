<?php

namespace App\Controller;


use App\Normalizer\UserNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/dashboard', name: 'dashboard_')]
#[IsGranted('ROLE_USER')]
class DashboardController extends AbstractController
{
    public function __construct(private UserNormalizer $normalizer)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/', name: 'index')]
    public function index(): Response
    {

        $user = $this->normalizer->normalize($this->getUser());

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
        ]);
    }


}
