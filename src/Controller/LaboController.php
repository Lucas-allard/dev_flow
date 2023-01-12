<?php

namespace App\Controller;

use App\Data\CourseFilterData;
use App\Entity\Course;
use App\Entity\UserCourse;
use App\Form\SearchCoursesFormType;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\LevelRepository;
use App\Repository\UserCourseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/labo', name: 'labo_')]
class LaboController extends AbstractController
{

    public function __construct(
        private CourseRepository   $courseRepository,
        private CategoryRepository $categoryRepository,
        private LevelRepository    $levelRepository,
        private PaginatorInterface $paginator,
        private UserCourseRepository $userCourseRepository,
    )
    {
    }

    private function checkToken(Request $request, Course $course): bool
    {
        $token = $request->query->get("token");

        return $this->isCsrfTokenValid('course' . $course->getId(), $token);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();

        $levels = $this->levelRepository->findAll();

        $filterData = new CourseFilterData();

        $searchForm = $this->createForm(SearchCoursesFormType::class, $filterData);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $coursesData = $this->courseRepository->findBySearch($filterData);
        } else {
            $coursesData = $this->courseRepository->findCourses();

        }

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

        $filterData = new CourseFilterData();

        $searchForm = $this->createForm(SearchCoursesFormType::class, $filterData);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $coursesData = $this->courseRepository->findBySearch($filterData);
        } else {
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

        $filterData = new CourseFilterData();

        $searchForm = $this->createForm(SearchCoursesFormType::class, $filterData);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $coursesData = $this->courseRepository->findBySearch($filterData);
        } else {
            $coursesData = $this->courseRepository->findByLevel($level);
        }


        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('labo/labo_by_level.html.twig', [
            "levels" => $levels,
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
//        $order = $order === "ASC" ? "DESC" : "ASC";

        $categories = $this->categoryRepository->findAll();

        $levels = $this->levelRepository->findAll();

        $filterData = new CourseFilterData();

        $searchForm = $this->createForm(SearchCoursesFormType::class, $filterData);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $coursesData = $this->courseRepository->findBySearch($filterData);
        } else {

            $coursesData = $this->courseRepository->findBy([], [$attr => $order]);
        }

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
        Request              $request,
        Course               $course,
    ): Response
    {
        $user = $this->getUser();

        if ($this->checkToken($request, $course)) {
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
        Request              $request,
        Course               $course,
    ): Response
    {

        $user = $this->getUser();

        if ($this->checkToken($request, $course)) {
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
        Course               $course,
        Request              $request
    ): Response
    {
        $user = $this->getUser();

        if ($this->checkToken($request, $course)) {
            if (!$this->userCourseRepository->findOneBy(['user' => $user, 'course' => $course])) {
                $userCourse = new UserCourse();
                $userCourse->setUser($user);
                $userCourse->setCourse($course);
            } else {
                $userCourse = $this->userCourseRepository->findOneBy(['user' => $user, 'course' => $course]);
            }

            $userCourse->setIsRead(true);
            $course->setReadCount($course->getReadCount() + 1);

            $this->userCourseRepository->save($userCourse, true);
            $this->courseRepository->save($course, true);


            $this->addFlash('success', 'Vous avez bien marqué ce cours comme lu');
        } else {
            $this->addFlash('danger', 'Vous avez déjà marqué ce cours comme lu');
        }

        return $this->redirectToRoute('labo_index');
    }

    /**
     * @throws NonUniqueResultException
     */
    public function hasPrevious(int $id): bool
    {
        $previous = $this->courseRepository->findPrevious($id);

        return $previous !== null;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function hasNext(int $id): bool
    {
        $next = $this->courseRepository->findNext($id);

        return $next !== null;
    }
}
