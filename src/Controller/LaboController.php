<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CategoryRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/labo', name: 'labo_')]
class LaboController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository, $courseRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $courses = $courseRepository->findAll();

        return $this->render('labo/labo.html.twig', [
            "categories" => $categories,
            "courses" => $courses,
        ]);
    }

}
