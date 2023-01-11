<?php

namespace App\Events;

use App\Entity\UserCourse;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class UserCourseReadSubscriber
{
    public function postPersist(LifecycleEventArgs $args): void
    {
        $userCourse = $args->getObject();

        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$userCourse instanceof UserCourse && !$userCourse->isIsRead()) {
            return;
        }

        $course = $userCourse->getCourse();
        $user = $userCourse->getUser();
        $course->setReadCount($course->getReadCount() + 1);
        $user->setReadCount($user->getReadCount() + 1);
        $user->setPoints($user->getPoints() + $course->getPoints());


        $entityManager = $args->getObjectManager();

        $entityManager->persist($course);
        $entityManager->persist($user);
        $entityManager->flush();
        // ... do something with the Product entity
    }
}
//class UserCourseReadSubscriber implements EventSubscriberInterface
//{
//
//    public static function getSubscribedEvents(): array
//    {
//        return [
//            Events::postPersist,
//            Events::postRemove,
//            Events::postUpdate,
//        ];
//    }
//
//    public function postPersist(LifecycleEventArgs $args): void
//    {
//        dd($args);
//        if ($userCourse->isIsRead()) {
//            $course  = $userCourse->getCourse();
//            $user    = $userCourse->getUser();
//            $course->setReadCount($course->getReadCount() + 1);
//            $user->setReadCount($user->getReadCount() + 1);
//            $user->setPoints($user->getPoints() + $course->getPoints());
//
//            $event->getObjectManager()->persist($course);
//        }
//    }
//
//}

