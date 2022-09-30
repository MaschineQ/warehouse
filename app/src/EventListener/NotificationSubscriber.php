<?php

declare(strict_types=1);

namespace App\EventListener;


use App\Entity\Product;
use App\Messaging\Notification\NotificationMessage;
use App\Service\Mailer;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationSubscriber implements EventSubscriber
{
    public function __construct(
        private MessageBusInterface $bus
    ) {}

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        //dd($entity);
        if ($entity instanceof Product) {
            if ($entity->getPackaging() < 10)
            $this->bus->dispatch(new NotificationMessage((string) $entity->getPackaging()));
        }

        // ... get the entity information and log it somehow
    }
}
