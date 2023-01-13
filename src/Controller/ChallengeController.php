<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ChallengeRepository;
use App\Repository\LevelRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/challenge', name: 'challenge_')]
    class ChallengeController extends ManagerController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private LevelRepository    $levelRepository,
        private ChallengeRepository $challengeRepository,
        private PaginatorInterface $paginator,
    )
    {
    }

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();

        $levels = $this->levelRepository->findAll();

        $challengeData = $this->challengeRepository->findChallenges();

        $challenges = $this->paginator->paginate(
            $challengeData,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('challenge/challenges.html.twig', [
            'categories' => $categories,
            'levels' => $levels,
            'challenges' => $challenges,
        ]);
    }
}
