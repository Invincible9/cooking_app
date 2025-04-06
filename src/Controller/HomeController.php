<?php

namespace App\Controller;

use App\Service\CourseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(CourseService $courseService) {
        $courses = $courseService->getAllCourses();
        return $this->render('home/index.html.twig', ['courses' => $courses]);
    }
}