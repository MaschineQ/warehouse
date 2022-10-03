<?php

namespace App\Messaging\Notification;

use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotificationHandler
{
    public function __construct(
        private Mailer         $mailer,
        private UserRepository $users
    ) {
    }

    public function __invoke(NotificationMessage $product): void
    {
        $product = $product->getProduct();

        $this->mailer->send(
            $this->getEmails(), //'test@test.com',
            'Notification',
            'notifications/notification_mail.html.twig',
            [
                'product' => $product,
                'productWarning' => NotificationMessage::PRODUCT_WARNING
            ]
        );
    }

    // todo zasilani notifikaci dle nastaveni z db
    public function getEmails(): string
    {
        $users = $this->users->findAll();

        $emails = [];
        foreach ($users as $user) {
            $emails[] = $user->getEmail();
        }

        return implode(',', $emails);
    }
}
