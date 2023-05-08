<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class MailService 
{
    private MailerInterface $mailer ;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer ;
    }

    public function sendEmail(
        string $from,
        string $subject,
        string $htmlTemplate,
        array $context,
        string $to = 'master@traiteapp.org'
    ):void
    {
              // mail 
              $email = (new TemplatedEmail())
              ->from($from)
              ->to($to)
              //->cc('cc@example.com')
              //->bcc('bcc@example.com')
              //->replyTo('fabien@example.com')
              //->priority(Email::PRIORITY_HIGH)
              ->subject($subject)
                  // path of the Twig template to render
              ->htmlTemplate($htmlTemplate)
  
      // pass variables (name => value) to the template
              ->context(
                $context
            );
              $this->mailer->send($email);
    }
}