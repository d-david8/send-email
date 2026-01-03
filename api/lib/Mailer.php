<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';



class Mailer {

    private $accounts;
    private $default_sender;
    private $host;
    private $port;

    public function __construct() {
        // Load mail configuration
        $config = require __DIR__ . '/../config/mail.php';
        $this->accounts = $config['accounts'];
        $this->default_sender = $config['default'];

        // SMTP settings
        $this->host = $config['host'] ?? 'mail.example.com';
        $this->port = $config['port'] ?? 465;
    }

    // Send email
    public function send($to, $subject, $body, $from = null, $attachments = []) {
        if (!$from || !isset($this->accounts[$from])) {
            $from = $this->default_sender;
        }
        $account = $this->accounts[$from];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->CharSet = 'UTF-8';
            $mail->Username = $account['email'];
            $mail->Password = $account['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $this->port;

            $mail->setFrom($account['email'], $account['name']);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Attachments
            foreach ($attachments as $file) {
                $mail->addAttachment($file['tmp_name'], $file['name']);
            }

            $mail->send();
            return ['status' => 'ok', 'message' => "Email sent successfully from {$account['email']}"];

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $mail->ErrorInfo];
        }
    }
}
