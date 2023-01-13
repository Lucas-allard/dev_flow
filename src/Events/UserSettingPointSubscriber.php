<?php

namespace App\Events;

use App\Entity\Challenge;
use App\Entity\Course;
use App\Entity\Level;
use App\Entity\User;
use App\Entity\UserChallenge;
use App\Entity\UserCourse;
use App\Repository\LevelRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UserSettingPointSubscriber implements EventSubscriber
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

        if (!$entity instanceof User) {
            return;
        }

        if (!$entity->getPoints()) {
            $entity->setLevel($entityManager->getRepository(Level::class)->findOneBy(['name' => 'Débutant']));
        }

        if ($entity->getPoints() > 249) {
            $entity->setLevel($entityManager->getRepository(Level::class)->findOneBy(['name' => 'Intermédiaire']));
        }

        if ($entity->getPoints() > 499) {
            $entity->setLevel($entityManager->getRepository(Level::class)->findOneBy(['name' => 'Avancé']));
        }

        if ($entity->getPoints() > 999) {
            $entity->setLevel($entityManager->getRepository(Level::class)->findOneBy(['name' => 'Expert']));
        }

        $entityManager->persist($entity);

        $entityManager->flush();
    }
}
