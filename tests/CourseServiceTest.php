<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\UserCourseView;
use App\Repository\UserCourseViewRepository;
use App\Service\CourseService;
use PHPUnit\Framework\TestCase;

class CourseServiceTest extends TestCase
{
    CONST COURSE_ACCESS_DELAY = '1 day';

    private UserCourseViewRepository $viewRepo;
    private CourseService $service;

    protected function setUp(): void
    {
        $this->viewRepo = $this->createMock(UserCourseViewRepository::class);
        $this->service = new CourseService($this->viewRepo, self::COURSE_ACCESS_DELAY);
    }

    public function testAdminCanAlwaysView(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);

        $this->assertTrue($this->service->canAccessCourse($user));
    }

    public function testUserWithLessThan10ViewsCanView(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->viewRepo->method('countTotalViews')->willReturn(5);

        $this->assertTrue($this->service->canAccessCourse($user));
    }

    public function testUserWithRecentViewCannotAccess(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->viewRepo->method('countTotalViews')->willReturn(12);

        $view = new UserCourseView();
        $view->setViewedAt(new \DateTimeImmutable('-10 minutes'));

        $this->viewRepo->method('findLatestView')->willReturn($view);

        $this->assertFalse($this->service->canAccessCourse($user));
    }

    public function testUserWithOldViewCanAccess(): void
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->viewRepo->method('countTotalViews')->willReturn(15);

        $view = new UserCourseView();
        $view->setViewedAt(new \DateTimeImmutable('-2 days'));

        $this->viewRepo->method('findLatestView')->willReturn($view);

        $this->assertTrue($this->service->canAccessCourse($user));
    }
}
