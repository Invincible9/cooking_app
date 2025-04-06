<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\User;
use App\Entity\UserCourseView;
use App\Repository\CourseRepository;
use App\Repository\UserCourseViewRepository;
use Doctrine\ORM\EntityManagerInterface;

class CourseService
{
    public function __construct(
        private UserCourseViewRepository $viewRepository,
        private CourseRepository $courseRepository,
        private readonly EntityManagerInterface $em,
        private string $courseAccessDelay // injected from parameters.yaml
    ) {}

    public function canAccessCourse(User $user): bool
    {
        // Is admin
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return true;
        }

        // Less than 10 views
        $totalViews = $this->viewRepository->countTotalViews($user);
        if ($totalViews < 10) {
            return true;
        }

        // Enough time passed since last view
        $lastView = $this->viewRepository->findLatestView($user);
        if (!$lastView) {
            return true; // allow if no views found
        }

        $lastViewedAt = $lastView->getViewedAt();
        $threshold = new \DateTimeImmutable('-' . $this->courseAccessDelay);
        return $lastViewedAt < $threshold;
    }

    public function getAllCourses(): array
    {
        return $this->courseRepository->findAll();
    }

    public function saveUserCourseView(User $user, Course $course) : void
    {
        $view = new UserCourseView();
        $view->setUser($user);
        $view->setCourse($course);
        $view->setViewedAt(new \DateTimeImmutable());
        $this->em->persist($view);
        $this->em->flush();
    }
}