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
use App\Services\SearchFormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/challenge', name: 'challenge_')]
class ChallengeController extends ManagerController
{
    private SearchFormHandler $searchFormHandler;

    /**
     * @param CategoryRepository $categoryRepository
     * @param LevelRepository $levelRepository
     * @param ChallengeRepository $challengeRepository
     * @param UserChallengeRepository $userChallengeRepository
     * @param PaginatorInterface $paginator
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private CategoryRepository      $categoryRepository,
        private LevelRepository         $levelRepository,
        private ChallengeRepository     $challengeRepository,
        private UserChallengeRepository $userChallengeRepository,
        private PaginatorInterface      $paginator,
        private FormFactoryInterface    $formFactory,
        private EntityManagerInterface  $entityManager,
    )
    {
        parent::__construct($this->challengeRepository);
        $this->searchFormHandler = new SearchFormHandler($this->formFactory, SearchChallengeFormType::class, $this->challengeRepository, new ChallengeFilterData());

    }

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $challengeData = $this->searchFormHandler->handleForm($request);

        $searchForm = $this->searchFormHandler->getSearchForm();

        if ($challengeData === null) {
            $challengeData = $this->challengeRepository->findChallenges();
        }

        $categories = $this->categoryRepository->findAll();

        $levels = $this->levelRepository->findAll();

        $challenges = $this->paginator->paginate(
            $challengeData,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('challenge/challenges.html.twig', [
            'categories' => $categories,
            'levels' => $levels,
            'challenges' => $challenges,
            'searchForm' => $searchForm->createView(),
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

        $challenges = $this->paginator->paginate(
            $this->challengeRepository->findBy([], [$attr => $order]),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('challenge/challenges.html.twig', [
            "categories" => $categories,
            "levels" => $levels,
            "challenges" => $challenges,
        ]);
    }

    /**
     * @param Request $request
     * @param Challenge $challenge
     * @return Response
     */
    #[Route('/like/{challenge}', name: 'like')]
    #[isGranted('ROLE_USER')]
    public function likeChallenge(
        Request   $request,
        Challenge $challenge,
    ): Response
    {

        $user = $this->getUser();

        if ($this->checkToken($request, 'challenge', $challenge)) {
            if (!$this->userChallengeRepository->findOneBy(['user' => $user, 'challenge' => $challenge])) {
                $userChallenge = new userChallenge();
                $userChallenge->setUser($user);
                $userChallenge->setChallenge($challenge);
            } else {
                $userChallenge = $this->userChallengeRepository->findOneBy(['user' => $user, 'challenge' => $challenge]);

            }

            $userChallenge->setIsLiked(true);
            $challenge->setLikeCount($challenge->getLikeCount() + 1);


            $this->userChallengeRepository->save($userChallenge);
            $this->challengeRepository->save($challenge);

            $this->entityManager->flush();

            $this->addFlash('success', 'Le challenge a bien été liké');
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @param Request $request
     * @param Challenge $challenge
     * @return Response
     */
    #[Route('/add/{challenge}', name: 'add')]
    #[isGranted('ROLE_USER')]
    public function addToUser(
        Request   $request,
        Challenge $challenge,
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

        return $this->redirect($request->headers->get('referer'));
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
            "challenge" => $challenge,
            "hasPrevious" => $hasPrevious,
            "hasNext" => $hasNext,
        ]);
    }

    #[Route('/complete/{challenge}', name: 'is_complete')]
    #[isGranted('ROLE_USER')]
    public function isComplete(
        Challenge $challenge,
        Request   $request
    ): Response
    {
        $user = $this->getUser();

        if ($this->checkToken($request, 'challenge', $challenge)) {
            if (!$this->userChallengeRepository->findOneBy(['user' => $user, 'challenge' => $challenge])) {
                $userChallenge = new UserChallenge();
                $userChallenge->setUser($user);
                $userChallenge->setChallenge($challenge);
            } else {
                $userChallenge = $this->userChallengeRepository->findOneBy(['user' => $user, 'challenge' => $challenge]);
            }

            $userChallenge->setIsComplete(true);
            $challenge->setCompleteCount($challenge->getCompleteCount() + 1);

            $this->userChallengeRepository->save($userChallenge);
            $this->challengeRepository->save($challenge,);

            $this->entityManager->flush();

            $this->addFlash('success', 'Vous avez bien complété ce challenge');
        } else {
            $this->addFlash('danger', 'Vous avez déjà complété ce challenge');
        }

        return $this->redirect($request->headers->get('referer'));
    }
}
