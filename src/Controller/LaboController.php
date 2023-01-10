<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/labo', name: 'labo_')]
class LaboController extends AbstractController
{
    /**
     * @param CategoryRepository $categoryRepository
     * @param CourseRepository $courseRepository
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository, CourseRepository $courseRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $courses = $courseRepository->findCourses();



        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "courses" => $courses,
        ]);
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @param CourseRepository $courseRepository
     * @param $category
     * @return Response
     */
    #[Route('/{category}', name: 'category')]
    public function category(CategoryRepository $categoryRepository, CourseRepository $courseRepository, $category): Response
    {
        $categories = $categoryRepository->findAll();
        $courses = $courseRepository->findByCategory($category);

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "courses" => $courses,
        ]);
    }
}
