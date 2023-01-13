<?php

namespace App\Events;

use App\Entity\Challenge;
use App\Entity\Course;
use App\Entity\Level;
use App\Entity\Trophy;
use App\Entity\User;
use App\Entity\UserChallenge;
use App\Entity\UserCourse;
use App\Repository\LevelRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Persistence\ObjectManager;

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

        $points = $entity->getPoints();

        $this->updateLevel($entity, $points, $entityManager);

        $this->updateTrophies($entity, $points, $entityManager);
    }

    private function updateLevel(User $user, int $points, ObjectManager $manager)
    {

        $levelRepository = $manager->getRepository(Level::class);

        $levels = $levelRepository->findAll();

        foreach ($levels as $level) {
            if ($points >= $level->getRequiredPoint()) {
                $user->setLevel($level);
                $manager->persist($user);
            }
        }

        $manager->flush();
    }

    private function updateTrophies(User $user, int $points, ObjectManager $manager)
    {


        $trophyRepository = $manager->getRepository(Trophy::class);

        $trophies = $trophyRepository->findAll();

        foreach ($trophies as $trophy) {
            if ($points >= $trophy->getRequiredPoint()) {
                $user->addTrophy($trophy);
                $manager->persist($user);
            }
        }

        $manager->flush();
    }
}
