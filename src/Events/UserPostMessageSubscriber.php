<?php

namespace App\Events;


use App\Entity\ChatMessage;
use App\Entity\Trophy;
use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Persistence\ObjectManager;

class UserPostMessageSubscriber implements EventSubscriber
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


        $this->updateTrophies($entity, $entityManager);
    }

    private function updateTrophies(User $user, ObjectManager $manager)
    {
        $trophyRepository = $manager->getRepository(Trophy::class);

        $trophies = $trophyRepository->findAll();
        $numberOfMessages = $user->getChatMessageCount();
        foreach ($trophies as $trophy) {
            if ($numberOfMessages >= $trophy->getRequiredMessages()) {
                $user->addTrophy($trophy);
                $manager->persist($user);
            }
        }

        $manager->flush();
    }
}
