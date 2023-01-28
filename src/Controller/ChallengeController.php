<?php

namespace App\Controller;

use App\Data\ChallengeFilterData;
use App\Entity\Challenge;
use App\Entity\UserChallenge;
use App\Form\SearchChallengeFormType;
use App\Repository\CategoryRepository;
use App\Repository\ChallengeRepository;
use App\Repository\LevelRepository;
use App\Repository\UserChallengeRepository;
use App\Services\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/challenge', name: 'challenge_')]
class ChallengeController extends ManagerController
{

    /**
     * @param CategoryRepository $categoryRepository
     * @param LevelRepository $levelRepository
     * @param Paginator $paginator
     * @param ChallengeRepository $challengeRepository
     * @param UserChallengeRepository $userChallengeRepository
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        private CategoryRepository      $categoryRepository,
        private LevelRepository         $levelRepository,
        private Paginator               $paginator,
        private ChallengeRepository     $challengeRepository,
        private UserChallengeRepository $userChallengeRepository,
        FormFactoryInterface            $formFactory,
    )
    {
        parent::__construct(
            $this->categoryRepository,
            $this->levelRepository,
            $this->paginator,
            $this->challengeRepository,
            SearchChallengeFormType::class,
            $formFactory,
            new ChallengeFilterData()
        );
    }


    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        return $this->getData(
            request: $request,
            view: 'challenge/challenges.html.twig',
            arg: 'challenges'
        );
    }

    /**
     * @param Request $request
     * @param string $category
     * @return Response
     */
    #[Route('/catégories/{category}', name: 'by_category')]
    public function category(Request $request, string $category): Response
    {
        return $this->getData(
            request: $request,
            view: 'challenge/challenges_by_category.html.twig',
            arg: 'challenges',
            entity: $category
        );
    }

    /**
     * @param Request $request
     * @param string $level
     * @return Response
     */
    #[Route('/levels/{level}', name: 'by_level')]
    public function level(Request $request, string $level): Response
    {
        return $this->getData(
            request: $request,
            view: 'challenge/challenges_by_level.html.twig',
            arg: 'challenges',
            entity: $level
        );
    }

    /**
     * @param Request $request
     * @param string $attr
     * @param string $order
     * @return Response
     */
    #[Route('/sort?attr={attr}&order={order}', name: 'sort')]
    public function sortChallenges(Request $request, string $attr, string $order): Response
    {
        return $this->getData(
            request: $request,
            view: 'challenge/challenges.html.twig',
            arg: 'challenges',
            attr: $attr,
            order: $order
        );
    }

    /**
     * @param Request $request
     * @param Challenge $challenge
     * @return Response
     */
    #[Route('/like/{challenge}', name: 'like')]
    #[isGranted('ROLE_USER')]
    public function likeChallenge(Request $request, Challenge $challenge): Response
    {
        return $this->like(
            $request,
            "challenge",
            $challenge,
            UserChallenge::class,
            $this->userChallengeRepository
        );
    }

    /**
     * @param Request $request
     * @param Challenge $challenge
     * @return Response
     */
    #[Route('/add/{challenge}', name: 'add')]
    #[isGranted('ROLE_USER')]
    public function addChallengeToUser(Request $request, Challenge $challenge): Response
    {
        return $this->addToUser(
            $request,
            "challenge",
            $challenge,
            UserChallenge::class,
            $this->userChallengeRepository
        );
    }

    #[Route('/show/{challenge}', name: 'show')]
    public function show(Challenge $challenge, Request $request): Response
    {
        return $this->showData(
            $request,
            $challenge,
            'challenge/challenge_show.html.twig',
        );
    }

    #[Route('/complete/{challenge}', name: 'is_complete')]
    #[isGranted('ROLE_USER')]
    public function isComplete(
        Challenge $challenge,
        Request   $request
    ): Response
    {
        return $this->updateStatus(
            $request,
            "challenge",
            $challenge,
            UserChallenge::class,
            $this->userChallengeRepository
        );
    }
}
