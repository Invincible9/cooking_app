<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Service\CourseService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseController extends AbstractController
{
    #[Route('/course/{id}', name: 'course_view')]
    public function view(
        int $id,
        CourseRepository $courseRepo,
        CourseService $courseService,
        UserService $userService
    ): Response
    {
        $course = $courseRepo->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }

        $user = $userService->getCurrentUser();
        $canView = $courseService->canAccessCourse($user);

        if ($canView) {
            $courseService->saveUserCourseView($user, $course);

            return $this->render('courses/view.html.twig', [
                'course' => $course,
                'canView' => true,
            ]);
        }

        return $this->render('courses/restricted.html.twig', [
            'course' => $course,
            'canView' => false,
        ]);
    }
}