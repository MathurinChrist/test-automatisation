<?php

    namespace App\Service;

    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;

    class SendEmail
    {
        /* MailerInterface $mailer*/
        private MailerInterface $mailer;
        public function __construct( MailerInterface $mailer) {
            $this->mailer = $mailer;
        }

        public function send(string $to, string $subject, string $content): void
        {
            $email = (new Email())
                ->from('todo@app.com')
                ->to($to)
                ->subject($subject)
                ->text($content);

            $this->mailer->send($email);
        }
    }
