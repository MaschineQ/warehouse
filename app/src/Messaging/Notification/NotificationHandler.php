<?php

namespace App\Messaging\Notification;


use App\Service\Mailer;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class NotificationHandler
{

    public function __construct
    (
        private Mailer $mailer
    )
    {}

    public function __invoke(NotificationMessage $message): void
    {
        $notification = $message->getContent();

        $this->mailer->send(
            'test@test.com',
            'Notification',
            'notifications/notification_mail.html.twig',
            [
                'message' => $notification,
            ]
        );
    }
}
