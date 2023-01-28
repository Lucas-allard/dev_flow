<?php

namespace App\Controller;

use App\Data\FilterDataInterface;
use App\Entity\Category;
use App\Entity\Challenge;
use App\Entity\Course;
use App\Entity\EntityInterface;
use App\Entity\Level;
use App\Entity\User;
use App\Entity\UserChallenge;
use App\Entity\UserCourse;
use App\Entity\UserEntity;
use App\Repository\CategoryRepository;
use App\Repository\FilterableRepositoryInterface;
use App\Repository\LevelRepository;
use App\Repository\UserEntityRepositoryInterface;
use App\Services\Paginator;
use App\Services\SearchFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ManagerController extends AbstractController
{
    private SearchFormHandler $searchFormHandler;

    public function __construct(
        private CategoryRepository              $categoryRepository,
        private LevelRepository                 $levelRepository,
        private Paginator                       $paginator,
        protected FilterableRepositoryInterface $repository,
        private                                 $formType,
        FormFactoryInterface                    $formFactory,
        private FilterDataInterface             $filterData,

    )
    {
        $this->searchFormHandler = new SearchFormHandler($formFactory);
    }


    public function getData(
        Request $request,
        string  $view,
        string  $arg,
        string  $entity = null,
        string  $attr = null,
        string  $order = null,
    ): Response
    {
        // if _route contains sort, then use repository->findBy else use repository->findAll
        $data = $this->getDataByRoute($request, $entity, $attr, $order);

        $paginatedData = $this->paginator->getPaginatedData($request, $data);

        $defaultOptions = [
            'categories' => $this->categoryRepository->findAll(),
            'levels' => $this->levelRepository->findAll(),
            $arg => $paginatedData,
            'searchForm' => $this->getSearchFormView(),
        ];

        $viewsOptions = $this->getViewsOption($request, $entity, $defaultOptions);

        return $this->getRenderView($view, $defaultOptions, $viewsOptions);
    }

    protected function showData(
        Request         $request,
        EntityInterface $entity,
        string          $view
    ): Response
    {
        $hasPrevious = $this->hasPrevious($entity->getId());
        $hasNext = $this->hasNext($entity->getId());

        $defaultOptions = [
            'hasPrevious' => $hasPrevious,
            'hasNext' => $hasNext,
        ];


        $viewsOptions = $this->getViewsOption($request, $entity);
        return $this->getRenderView($view, $defaultOptions, $viewsOptions);
    }


    private function getDataByRoute(
        Request $request,
        string  $entity = null,
        string  $attr = null,
        string  $order = null
    ): array
    {
        $route = $request->attributes->get('_route');

        if (str_contains($route, 'sort')) {
            return $this->getResult($request, $this->repository->findBy([], [$attr => $order]));
        } else if (str_contains($route, 'by_category')) {
            return $this->getResult($request, $this->repository->findByCategory($entity));
        } else if (str_contains($route, 'by_level')) {
            return $this->getResult($request, $this->repository->findByLevel($entity));
        }

        return $this->getResult($request, $this->repository->findAll());
    }

    private function getViewsOption(Request $request, $entity, array $defaultOptions = null): array
    {
        $route = $request->attributes->get('_route');
        if (str_contains($route, 'by_category')) {
            unset($defaultOptions['levels']);
            return [
                'category' => $entity,
            ];
        } elseif (str_contains($route, 'by_level')) {
            unset($defaultOptions['categories']);
            return [
                'level' => $entity,
            ];
        }
        if ($route === 'labo_course_show') {
            return [
                'course' => $entity,
            ];
        } elseif ($route === 'challenge_show') {
            return [
                'challenge' => $entity,
            ];
        }

        return [];
    }

    private function getRenderView($view, array $defaultOptions, $viewsOptions = null): Response
    {
        return $this->render($view, array_merge($viewsOptions, $defaultOptions));
    }

    protected
    function handleSearchForm(Request $request): ?array
    {
        $form = $this->searchFormHandler->createForm($this->formType, $this->filterData);
        if ($this->searchFormHandler->handleForm($request)) {
            return $this->repository->findBySearch($form->getData());
        }
        return null;
    }

    protected function getSearchFormView(): FormView
    {
        return $this->searchFormHandler->getSearchFormView();
    }

    protected function getResult(Request $request, $query): array
    {
        $challengeData = $this->handleSearchForm($request);

        if ($challengeData === null) {
            $challengeData = $query;
        }

        return $challengeData;
    }

    /**
     * @param Request $request
     * @param string $name
     * @param object $entity
     * @return bool
     */
    protected
    function checkToken(Request $request, string $name, object $entity): bool
    {
        $token = $request->query->get("token");

        return $this->isCsrfTokenValid($name . $entity->getId(), $token);
    }

    protected
    function hasPrevious(int $id): bool
    {
        $previous = $this->repository->findPrevious($id);

        return $previous !== null;
    }

    protected
    function hasNext(int $id): bool
    {
        $next = $this->repository->findNext($id);

        return $next !== null;
    }

    protected function addToUser(
        Request                       $request,
        string                        $tokenName,
        EntityInterface               $entity,
        string                        $userEntityClass,
        UserEntityRepositoryInterface $repository
    ): RedirectResponse
    {
        if (!$this->checkToken($request, $tokenName, $entity) || $this->userEntityExist($this->getUser(), $tokenName, $entity, $repository)) {
            return $this->redirect($request->headers->get('referer'));
        }

        $userEntity = $this->createUserEntity($userEntityClass);
        $userEntity->setUser($this->getUser());
        $this->setObject($userEntity, $entity, $tokenName);

        $this->saveUserEntity($userEntity, $repository);

        $this->addFlash('success', 'L\'élément a bien été ajouté à votre liste');

        return $this->redirect($request->headers->get('referer'));
    }

    protected function like(
        Request                       $request,
        string                        $tokenName,
        EntityInterface               $entity,
        string                        $userEntityClass,
        UserEntityRepositoryInterface $repository
    )
    {
        if (!$this->checkToken($request, $tokenName, $entity) || $this->userAlreadyLike($this->getUser(), $tokenName, $entity, $repository)) {
            return $this->redirect($request->headers->get('referer'));
        }

        $userEntity = $this->getUserEntity($this->getUser(), $tokenName, $entity, $repository, $userEntityClass);

        $userEntity->setUser($this->getUser());
        $this->setObject($userEntity, $entity, $tokenName);
        $this->setObject($userEntity, true, "isLiked");
        $this->setObject($entity, $entity->getLikeCount() + 1, "likeCount");

        $this->saveUserEntity($userEntity, $repository);

        $this->addFlash('success', 'L\'élément a bien été liké');

        return $this->redirect($request->headers->get('referer'));
    }

    protected function updateStatus(
        Request                       $request,
        string                        $tokenName,
        EntityInterface               $entity,
        string                        $userEntityClass,
        UserEntityRepositoryInterface $userEntityRepository
    )
    {
        if (!$this->checkToken($request, $tokenName, $entity) || $this->statusAlreadyUpdated($this->getUser(), $tokenName, $entity, $userEntityRepository)) {
            return $this->redirect($request->headers->get('referer'));
        }
        $userEntity = $this->getUserEntity($this->getUser(), $tokenName, $entity, $userEntityRepository, $userEntityClass);

        $userEntity->setUser($this->getUser());

        $this->setObject($userEntity, $entity, $tokenName);

        $this->setStatus($userEntity);

        $this->setCount($entity);

        $this->saveUserEntity($userEntity, $userEntityRepository);

        $this->saveEntity($entity, $this->repository);

        $this->addFlash('success', 'L\'élément a bien été mis à jour');

        return $this->redirect($request->headers->get('referer'));
    }

    private function userEntityExist(User $user, string $entityName, EntityInterface $entity, $repository): bool
    {
        $userEntity = $repository->findOneBy(['user' => $user, $entityName => $entity]);
        if ($userEntity) {
            $this->addFlash('danger', 'Vous avez déjà ajouté cet élément à votre liste');
            return true;
        }
        return false;
    }

    //verify if user already like
    private function userAlreadyLike(User $user, string $entityName, EntityInterface $entity, $repository): bool
    {
        $userEntity = $repository->findOneBy(['user' => $user, $entityName => $entity]);
        // verify if props isliked is true or false

        if ($userEntity && $userEntity->isIsLiked() === true) {
            $this->addFlash('danger', 'Vous avez déjà liké cet élément');
            return true;
        }
        return false;
    }

    private function statusAlreadyUpdated(User $user, string $entityName, EntityInterface $entity, $repository): bool
    {
        $userEntity = $repository->findOneBy(['user' => $user, $entityName => $entity]);

        if ($userEntity instanceof UserChallenge && $userEntity->isIsComplete() === true) {
            $this->addFlash('danger', 'Vous avez déjà complété ce challenge');
            return true;
        } elseif ($userEntity instanceof UserCourse && $userEntity->isIsRead() === true) {
            $this->addFlash('danger', 'Vous avez déjà lu ce cours');
            return true;
        }
        return false;
    }

    private function getUserEntity(User $user, string $entityName, EntityInterface $entity, $repository, $userEntityClass): ?UserEntity
    {
        return $repository->findOneBy(['user' => $user, $entityName => $entity]) ?? $this->createUserEntity($userEntityClass);
    }

    private function createUserEntity(string $userEntityClass): UserEntity
    {
        return new $userEntityClass();
    }

    private function setObject(UserEntity|EntityInterface $entity, EntityInterface|bool $arg, string $entityProperty): void
    {
        $setMethod = 'set' . ucfirst($entityProperty);
        if (method_exists($entity, $setMethod)) {
            $entity->$setMethod($arg);
        }
    }

    private function setStatus($userEntity)
    {
        // verify if userEntity is a course or a challenge
        if ($userEntity instanceof UserCourse) {
            $userEntity->setIsRead(true);
        } elseif ($userEntity instanceof UserChallenge) {
            $userEntity->setIsComplete(true);
        }
    }

    public function setCount($entity)
    {
        if ($entity instanceof Course) {
            $entity->setReadCount($entity->getReadCount() + 1);
        } elseif ($entity instanceof Challenge) {
            $entity->setCompleteCount($entity->getCompleteCount() + 1);
        }
    }

    private function saveUserEntity(UserEntity $userEntity, UserEntityRepositoryInterface $repository): void
    {
        $repository->save($userEntity, true);
    }

    public function saveEntity(EntityInterface $entity, $repository)
    {
        $repository->save($entity, true);
    }

}