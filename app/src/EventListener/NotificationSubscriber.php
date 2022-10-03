<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Product;
use App\Messaging\Notification\NotificationMessage;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;

class NotificationSubscriber implements EventSubscriber
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

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

        if ($entity instanceof Product) {
            if ($entity->getPackaging() < NotificationMessage::PRODUCT_WARNING) {
                $this->bus->dispatch(new NotificationMessage($entity));
            }
        }
    }
}
