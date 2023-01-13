<?php

namespace App\Controller;

use App\Data\FilterData;
use App\Entity\Course;
use App\Entity\User;
use App\Entity\UserCourse;
use App\Form\SearchCoursesFormType;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\FilterableRepositoryInterface;
use App\Repository\LevelRepository;
use App\Repository\UserCourseRepository;
use App\Repository\UserRepository;
use App\Services\SearchFormHandler;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/labo', name: 'labo_')]
class LaboController extends ManagerController
{


    /**
     * @param CourseRepository $courseRepository
     * @param CategoryRepository $categoryRepository
     * @param LevelRepository $levelRepository
     * @param PaginatorInterface $paginator
     * @param UserCourseRepository $userCourseRepository
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        private CourseRepository     $courseRepository,
        private CategoryRepository   $categoryRepository,
        private LevelRepository      $levelRepository,
        private PaginatorInterface   $paginator,
        private UserCourseRepository $userCourseRepository,
        private FormFactoryInterface $formFactory,
//        private SearchFormHandler    $searchFormHandler,
    )
    {

        parent::__construct($this->courseRepository);
//        $this->searchFormHandler = new SearchFormHandler($this->formFactory, $this->courseRepository, SearchCoursesFormType::class, new FilterData());
    }


    /**
     * @param Request $request
     * @param FormFactoryInterface $formFactory
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(
        Request              $request,
    ): Response
    {

        $searchFormHandler = new SearchFormHandler($this->formFactory, $this->courseRepository, SearchCoursesFormType::class, new FilterData());
        $coursesData = $searchFormHandler->handleSearchForm($request);

        $searchForm = $searchFormHandler->getSearchForm();

        if ($coursesData === null) {
            $coursesData = $this->courseRepository->findCourses();
        }

        $categories = $this->categoryRepository->findAll();
        $levels = $this->levelRepository->findAll();

        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "searchForm" => $searchForm->createView(),
            "levels" => $levels,
            "courses" => $courses,
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

        $searchFormHandler = new SearchFormHandler($this->formFactory, $this->courseRepository, SearchCoursesFormType::class, new FilterData());
        $coursesData = $searchFormHandler->handleSearchForm($request);

        $searchForm = $searchFormHandler->getSearchForm();

        if ($coursesData === null) {
            $coursesData = $this->courseRepository->findByCategory($category);
        }

        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('labo/labo_by_category.html.twig', [
            "categories" => $categories,
            "category" => $category,
            "courses" => $courses,
            "searchForm" => $searchForm->createView(),
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

        $searchFormHandler = new SearchFormHandler($this->formFactory, $this->courseRepository, SearchCoursesFormType::class, new FilterData());
        $coursesData = $searchFormHandler->handleSearchForm($request);

        $searchForm = $searchFormHandler->getSearchForm();

        if ($coursesData === null) {
            $coursesData = $this->courseRepository->findByLevel($level);
        }

        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('labo/labo_by_level.html.twig', [
            "levels" => $levels,
            "level" => $level,
            "courses" => $courses,
            "searchForm" => $searchForm->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $attr
     * @param string $order
     * @return Response
     */
    #[Route('/sort?attr={attr}&order={order}', name: 'sort')]
    public function sortCourse(Request $request, string $attr, string $order): Response
    {
        $categories = $this->categoryRepository->findAll();

        $levels = $this->levelRepository->findAll();

        $searchFormHandler = new SearchFormHandler($this->formFactory, $this->courseRepository, SearchCoursesFormType::class, new FilterData());
        $coursesData = $searchFormHandler->handleSearchForm($request);

        $searchForm = $searchFormHandler->getSearchForm();

        if ($coursesData === null) {
            $coursesData = $this->courseRepository->findBy([], [$attr => $order]);        }

        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "searchForm" => $searchForm->createView(),
            "levels" => $levels,
            "courses" => $courses,
        ]);
    }


    /**
     * @param Request $request
     * @param Course $course
     * @return Response
     */
    #[Route('/add/{course}', name: 'course_add')]
    #[isGranted('ROLE_USER')]
    public function addToUser(
        Request $request,
        Course  $course,
    ): Response
    {
        $user = $this->getUser();

        if ($this->checkToken($request, 'course', $course)) {
            $userCourse = new UserCourse();
            $userCourse->setUser($user);
            $userCourse->setCourse($course);
            $this->userCourseRepository->save($userCourse, true);

            $this->addFlash('success', 'Le cours a bien été ajouté à votre liste de cours');
        } else {
            $this->addFlash('danger', 'Vous avez déjà ajouté ce cours à votre liste de cours');
        }


        return $this->redirectToRoute('labo_index');
    }

    /**
     * @param Request $request
     * @param Course $course
     * @return Response
     */
    #[Route('/like/{course}', name: 'course_like')]
    #[isGranted('ROLE_USER')]
    public function likeCourse(
        Request $request,
        Course  $course,
    ): Response
    {

        $user = $this->getUser();

        if ($this->checkToken($request, 'course', $course)) {
            if (!$this->userCourseRepository->findOneBy(['user' => $user, 'course' => $course])) {
                $userCourse = new UserCourse();
                $userCourse->setUser($user);
                $userCourse->setCourse($course);
            } else {
                $userCourse = $this->userCourseRepository->findOneBy(['user' => $user, 'course' => $course]);

            }

            $userCourse->setIsLiked(true);

            $course->setLikeCount($course->getLikeCount() + 1);

            $this->userCourseRepository->save($userCourse, true);
            $this->courseRepository->save($course, true);

            $this->addFlash('success', 'Le cours a bien été liké');
        }

        return $this->redirectToRoute('labo_index');
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/show/{course}', name: 'course_show')]
    public function show(Course $course): Response
    {
        $hasPrevious = $this->hasPrevious($course->getId());
        $hasNext = $this->hasNext($course->getId());

        return $this->render('labo/course_show.html.twig', [
            "course" => $course,
            "hasPrevious" => $hasPrevious,
            "hasNext" => $hasNext,
        ]);
    }

    /**
     * @param Course $course
     * @param Request $request
     * @return Response
     */
    #[Route('/read/{course}', name: 'course_is_read')]
    #[isGranted('ROLE_USER')]
    public function isRead(
        Course  $course,
        UserRepository $userRepository,
        Request $request
    ): Response
    {

        /** @var User $user */
        $user = $this->getUser();

        if ($this->checkToken($request, 'course', $course)) {
            if (!$this->userCourseRepository->findOneBy(['user' => $user, 'course' => $course])) {
                $userCourse = new UserCourse();
                $userCourse->setUser($user);
                $userCourse->setCourse($course);
            } else {
                $userCourse = $this->userCourseRepository->findOneBy(['user' => $user, 'course' => $course]);
            }

            $userCourse->setIsRead(true);
            $course->setReadCount($course->getReadCount() + 1);
            $user->setReadCount($user->getReadCount() + 1);

            $this->userCourseRepository->save($userCourse, true);
            $this->courseRepository->save($course, true);
            $userRepository->save($user, true);


            $this->addFlash('success', 'Vous avez bien marqué ce cours comme lu');
        } else {
            $this->addFlash('danger', 'Vous avez déjà marqué ce cours comme lu');
        }

        return $this->redirectToRoute('labo_index');
    }

}
