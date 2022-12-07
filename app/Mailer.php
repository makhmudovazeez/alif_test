<?php

namespace App;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    public static function sendMail(string $address, string $subject, string $body): bool {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'azeezmakhmudov@gmail.com';
            $mail->Password = 'mbvzweecfhgjwaen';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom("booking@gmail.com");
            $mail->addAddress($address);
            $mail->Subject = $subject;
            $mail->Body = $body;
            return $mail->send();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}