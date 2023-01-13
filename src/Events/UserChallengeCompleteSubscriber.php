<?php

namespace App\Events;

use App\Entity\Challenge;
use App\Entity\Course;
use App\Entity\UserChallenge;
use App\Entity\UserCourse;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserChallengeCompleteSubscriber implements EventSubscriber
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

        if (!$entity instanceof Challenge) {
            return;
        }

        $userChallenge = $entityManager->getRepository(UserChallenge::class)->findOneBy(['challenge' => $entity->getId()]);

        $user = $userChallenge->getUser();
        if ($userChallenge->isIsComplete()) {
            $points = $entity->getPoints();
            $user->setPoints($user->getPoints() + $points);
        }

        $entityManager->persist($user);

        $entityManager->flush();
    }
}
