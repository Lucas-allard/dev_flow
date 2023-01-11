<?php

namespace App\Controller;

use App\Data\CourseFilterData;
use App\Data\SearchData;
use App\Entity\Course;
use App\Form\SearchCoursesFormType;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\LevelRepository;
use App\Repository\UserRepository;
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
            16
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
            16
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
            16
        );

        return $this->render('labo/labo_by_level.html.twig', [
            "levels" => $levels,
            "courses" => $courses,
            "searchForm" => $searchForm->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $category
     * @param string $level
     * @return Response
     */
    #[Route('/catégories/{category}/levels/{level}', name: 'by_category_and_level')]
    public function categoryAndLevel(Request $request, string $category, string $level): Response
    {
        $categories = $this->categoryRepository->findAll();
        $levels = $this->levelRepository->findAll();
        $coursesData = $this->courseRepository->findByCategoryAndLevel($category, $level);

        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            16
        );

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "levels" => $levels,
            "courses" => $courses,
        ]);
    }

    #[Route('/add/{course}', name: 'course_add')]
    #[isGranted('ROLE_USER')]
    public function addToUser(Request $request,Course $course, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if ($this->checkToken($request, $course)) {
            $user->addCourse($course);
            $userRepository->save($user, true);

            $this->addFlash('success', 'Le cours a bien été ajouté à votre liste de cours');
        } else {
            $this->addFlash('danger', 'Vous avez déjà ajouté ce cours à votre liste de cours');
        }


        return $this->redirectToRoute('labo_index');
    }

    #[Route('/show/{course}', name: 'course_show')]
    public function show(Course $course): Response
    {
        return $this->render('labo/course_show.html.twig', [
            "course" => $course,
        ]);
    }
}
