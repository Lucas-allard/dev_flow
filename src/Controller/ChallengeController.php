<?php

namespace App\Controller;

use App\Data\FilterData;
use App\Entity\Challenge;
use App\Entity\UserChallenge;
use App\Form\SearchCoursesFormType;
use App\Repository\CategoryRepository;
use App\Repository\ChallengeRepository;
use App\Repository\LevelRepository;
use App\Repository\UserChallengeRepository;
use App\Services\SearchFormHandler;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/challenge', name: 'challenge_')]
class ChallengeController extends ManagerController
{
    public function __construct(
        private CategoryRepository  $categoryRepository,
        private LevelRepository     $levelRepository,
        private ChallengeRepository $challengeRepository,
        private UserChallengeRepository $userChallengeRepository,
        private PaginatorInterface  $paginator,
    )
    {
        parent::__construct($this->challengeRepository);
    }

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();

        $levels = $this->levelRepository->findAll();


        $challenges = $this->paginator->paginate(
            $this->challengeRepository->findChallenges(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('challenge/challenges.html.twig', [
            'categories' => $categories,
            'levels' => $levels,
            'challenges' => $challenges,
        ]);
    }

    /**
     * @param Request $request
     * @param string $category
     * @return Response
     */
    #[Route('/catégories/{category}', name: 'by_category')]
    public function category(Request $request, string $category): Response
    {
        $categories = $this->categoryRepository->findAll();

        $challenges = $this->paginator->paginate(
            $this->challengeRepository->findByCategory($category),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('challenge/challenges_by_category.html.twig', [
            "categories" => $categories,
            "category" => $category,
            "challenges" => $challenges,
        ]);
    }

    /**
     * @param Request $request
     * @param string $level
     * @return Response
     */
    #[Route('/levels/{level}', name: 'by_level')]
    public function level(Request $request, string $level): Response
    {
        $levels = $this->levelRepository->findAll();

        $challenges = $this->paginator->paginate(
            $this->challengeRepository->findByLevel($level),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('challenge/challenges_by_level.html.twig', [
            "levels" => $levels,
            "level" => $level,
            "challenges" => $challenges,

        ]);
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
        $categories = $this->categoryRepository->findAll();

        $levels = $this->levelRepository->findAll();

        $courses = $this->paginator->paginate(
            $this->challengeRepository->findBy([], [$attr => $order]),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "levels" => $levels,
            "courses" => $courses,
        ]);
    }

    #[Route('/add/{challenge}', name: 'add')]
    #[isGranted('ROLE_USER')]
    public function addToUser(
        Request $request,
        Challenge  $challenge,
    ): Response
    {
        $user = $this->getUser();

        if ($this->checkToken($request, 'challenge', $challenge)) {
            $userChallenge = new UserChallenge();
            $userChallenge->setUser($user);
            $userChallenge->setChallenge($challenge);
            $this->userChallengeRepository->save($userChallenge, true);

            $this->addFlash('success', 'Le challenge a bien été ajouté à votre liste de challenge');
        } else {
            $this->addFlash('danger', 'Vous avez déjà ajouté ce challenge à votre liste de challenge');
        }

        return $this->redirectToRoute('labo_index');
    }


    /**
     * @throws NonUniqueResultException
     * @throws NonUniqueResultException
     */
    #[Route('/show/{challenge}', name: 'show')]
    public function show(Challenge $challenge): Response
    {
        $hasPrevious = $this->hasPrevious($challenge->getId());
        $hasNext = $this->hasNext($challenge->getId());

        return $this->render('challenge/challenge_show.html.twig', [
            "course" => $challenge,
            "hasPrevious" => $hasPrevious,
            "hasNext" => $hasNext,
        ]);
    }
}
