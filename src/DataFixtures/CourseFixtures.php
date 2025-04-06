<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $youtubeLinks = [
            'https://www.youtube.com/watch?v=mhDJNfV7hjk',
            'https://www.youtube.com/watch?v=pk0ncEW6bQ8',
            'https://www.youtube.com/watch?v=jPECQ0dU2-s',
            'https://www.youtube.com/watch?v=ZQnpYcvXHtU',
            'https://www.youtube.com/watch?v=N2G6YNtLUOg',
        ];

        foreach ($youtubeLinks as $i => $url) {
            $course = new Course();
            $course->setName("Course #" . $i + 1);
            $course->setYoutubeUrl($url);
            $manager->persist($course);
        }

        $manager->flush();
    }
}
