<?php

namespace App\Events;

use App\Entity\Course;
use App\Entity\UserCourse;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserCourseReadSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::postUpdate,
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        $entityManager = $args->getObjectManager();

        if (!$entity instanceof Course) {
            return;
        }

        $userCourse = $entityManager->getRepository(UserCourse::class)->findOneBy(['course' => $entity->getId()]);

        $user = $userCourse->getUser();
        if ($userCourse->isIsRead()) {
            $points = $entity->getPoints();
            $user->setPoints($user->getPoints() + $points);
        }

        $entityManager->persist($user);

        $entityManager->flush();
    }
}
