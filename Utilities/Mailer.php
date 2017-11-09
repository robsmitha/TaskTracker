<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

class Mailer
{
    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getMailSettings() { return "mail_localsettings.php"; }

    public static function sendRegistrationEmail($recipientEmail) {
        include_once(self::getMailSettings());

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $smtpUsername;                // SMTP username
            $mail->Password = $smtpPassword;                // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                              // TCP port to connect to

            //Recipients
            $mail->setFrom($smtpUsername, 'OpenDevTools');
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($smtpUsername, 'NoReply');

            //Content
            $body = '<p>Greetings! An account was recently created on <a href="https://tasktracker.opendevtools.org">www.opendevtools.org</a> using this email address.</p>';
            $body = $body . '<br/><p>If you believe you have received this message in error, please contact our <a href="mailto:info@opendevtools.org">Site Administrators</a>.</p>';

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Task Tracker Registration Successful';
            $mail->Body    = $body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Set SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

}