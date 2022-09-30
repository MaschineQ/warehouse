<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
    private MailerInterface $mailer;
    private string $addressFrom;

    public function __construct(string $addressFrom, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->addressFrom = $addressFrom;
    }

    public function send(string $address, string $subject, string $template, array $context = []): void
    {
        $email = (new TemplatedEmail())
            ->from($this->addressFrom)
            ->to($address)
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new \RuntimeException('cannot send email', 0, $e);
        }
    }
}
