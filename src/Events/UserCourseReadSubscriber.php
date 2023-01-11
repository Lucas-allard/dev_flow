<?php

namespace App\Events;

use App\Entity\UserCourse;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserCourseReadSubscriber implements EventSubscriberInterface
{
    public function postUpdate(UserCourse $userCourse, PostUpdateEventArgs  $event): void
    {
        if ($userCourse->isIsRead()) {
            $course  = $userCourse->getCourse();
            $user    = $userCourse->getUser();
            $course->setReadCount($course->getReadCount() + 1);
            $user->setReadCount($user->getReadCount() + 1);
            $user->setPoints($user->getPoints() + $course->getPoints());

            $event->getObjectManager()->persist($course);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'postUpdate',
        ];
    }
}

