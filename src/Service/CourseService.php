<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserCourseViewRepository;

class CourseService
{
    public function __construct(
        private UserCourseViewRepository $viewRepository,
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
}