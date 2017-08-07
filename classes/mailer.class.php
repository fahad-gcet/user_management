<?php 
require_once 'libs/swiftmailer/lib/swift_required.php';

class Mail {

    public function sendVerificationMail($email, $link) {
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername(USERNAME)
            ->setPassword(PASSWORD);
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance('Email Verification')
            ->setFrom(array(USERNAME . '@' . PROVIDER . '.com' => 'admin@profilehub.com'))
            ->setTo($email)
            ->setBody('<html>' . ' <head></head>' . ' <body>' . ' Thanks for signing up. Click on  ' .   $link.  ' to activate your account.' . ' </body>' . '</html>', 'text/html');
        $result = $mailer->send($message);
      }
    }
?>