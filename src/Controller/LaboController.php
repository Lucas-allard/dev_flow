<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\LevelRepository;
use Knp\Component\Pager\PaginatorInterface;
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

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();
        $levels = $this->levelRepository->findAll();
        $coursesData = $this->courseRepository->findCourses();

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

    /**
     * @param Request $request
     * @param string $category
     * @return Response
     */
    #[Route('/catégories/{category}', name: 'by_category')]
    public function category(Request $request, string $category): Response
    {
        $categories = $this->categoryRepository->findAll();

        $coursesData = $this->courseRepository->findByCategory($category);
        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            16
        );

        return $this->render('labo/labo_by_category.html.twig', [
            "categories" => $categories,
            "category" => $category,
            "courses" => $courses,
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
        $coursesData = $this->courseRepository->findByLevel($level);

        $courses = $this->paginator->paginate(
            $coursesData,
            $request->query->getInt('page', 1),
            16
        );

        return $this->render('labo/labo_by_level.html.twig', [
            "levels" => $levels,
            "courses" => $courses,
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
}
