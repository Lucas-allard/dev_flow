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
use App\Services\Paginator;
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
     * @param Paginator $paginator
     * @param UserCourseRepository $userCourseRepository
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        private CourseRepository       $courseRepository,
        private CategoryRepository     $categoryRepository,
        private LevelRepository        $levelRepository,
        private Paginator              $paginator,
        private UserCourseRepository   $userCourseRepository,
        FormFactoryInterface           $formFactory,
    )
    {
        parent::__construct(
            $this->categoryRepository,
            $this->levelRepository,
            $this->paginator,
            $this->courseRepository,
            SearchCoursesFormType::class,
            $formFactory,
            new CourseFilterData()
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(
        Request $request,
    ): Response
    {
        return $this->getData(
            request: $request,
            view: 'labo/labo.html.twig',
            arg: 'courses'
        );
    }

    /**
     * @param Request $request
     * @param string $category
     * @return Response
     */
    #[Route('/catégories/{category}', name: 'by_category')]
    public function category(Request $request, string $category): Response
    {
        return $this->getData(
            request: $request,
            view: 'labo/labo_by_category.html.twig',
            arg: 'courses',
            entity: $category
        );
    }

    /**
     * @param Request $request
     * @param string $level
     * @return Response
     */
    #[Route('/levels/{level}', name: 'by_level')]
    public function level(Request $request, string $level): Response
    {
        return $this->getData(
            request: $request,
            view: 'labo/labo_by_level.html.twig',
            arg: 'courses',
            entity: $level
        );
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
        return $this->getData(
            request: $request,
            view: 'labo/labo.html.twig',
            arg: 'courses',
            attr: $attr,
            order: $order
        );
    }


    /**
     * @param Request $request
     * @param Course $course
     * @return Response
     */
    #[Route('/add/{course}', name: 'course_add')]
    #[isGranted('ROLE_USER')]
    public function addCourseToUser(
        Request $request,
        Course  $course,
    ): Response
    {
        return $this->addToUser(
            $request,
            "course",
            $course,
            UserCourse::class,
            $this->userCourseRepository
        );
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
        return $this->like(
            $request,
            "course",
            $course,
            UserCourse::class,
            $this->userCourseRepository
        );
    }

    #[Route('/show/{course}', name: 'course_show')]
    public function show(Course $course, Request $request): Response
    {
        return $this->showData(
            $request,
            $course,
            'labo/course_show.html.twig',
        );
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
        Request $request
    ): Response
    {
        return $this->updateStatus(
            $request,
            "course",
            $course,
            UserCourse::class,
            $this->userCourseRepository
        );
    }
}
