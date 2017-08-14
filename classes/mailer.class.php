<?php 
require_once dirname(dirname(__FILE__))  .'/libs/swiftmailer/lib/swift_required.php';

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

      public function sendClientCredentials($email, $access_identifier, $access_secret) {
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
            ->setUsername(USERNAME)
            ->setPassword(PASSWORD);
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance('API Credentials')
            ->setFrom(array(USERNAME . '@' . PROVIDER . '.com' => 'admin@profilehub.com'))
            ->setTo($email)
            ->setBody('<html>' . ' <head></head>' . ' <body>' . ' Thanks!! Your request has been approved.<br><br> Access Identifier: ' .   $access_identifier.  '<br>Access Secret: ' . $access_secret . ' </body>' . '</html>', 'text/html');
        $result = $mailer->send($message);
      }
    }
?>