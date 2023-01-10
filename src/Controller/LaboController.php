<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\LevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/labo', name: 'labo_')]
class LaboController extends AbstractController
{

    public function __construct(
        private CourseRepository   $courseRepository,
        private CategoryRepository $categoryRepository,
        private LevelRepository    $levelRepository,
    )
    {
    }

    /**
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findAll();
        $levels = $this->levelRepository->findAll();
        $courses = $this->courseRepository->findCourses();


        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "levels" => $levels,
            "courses" => $courses,
        ]);
    }

    /**
     * @param string $category
     * @return Response
     */
    #[Route('/catégories/{category}', name: 'by_category')]
    public function category(string $category): Response
    {
        $categories = $this->categoryRepository->findAll();
        $levels = $this->levelRepository->findAll();
        $courses = $this->courseRepository->findByCategory($category);

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "levels" => $levels,
            "courses" => $courses,
        ]);
    }

    /**
     * @param string $level
     * @return Response
     */
    #[Route('/levels/{level}', name: 'by_level')]
    public function level(string $level): Response
    {
        $categories = $this->categoryRepository->findAll();
        $levels = $this->levelRepository->findAll();
        $courses = $this->courseRepository->findByLevel($level);

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "levels" => $levels,
            "courses" => $courses,
        ]);
    }
}
