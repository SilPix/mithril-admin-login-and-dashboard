<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/Exception.php';
require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';

$mail = new PHPMailer(true);

$fullname = 'Bro';
$email = "e4luckygamer14@gmail.com";
$hash = "dcg2rj3b3h";

try {
	$mail->isSendmail();
    $mail->setFrom('moth.aj28@gmail.com', 'Mithril-Registry');
    $mail->addAddress('e4luckygamer14@gmail.com');

    // Content
    $mail->Subject = "Mithril | Verify your E-mail";
    $mail->Body = '
	Thank you' . $fullname . 'for registering. There is one more step before you account is activated.
	Please click on the link below to verify your E-mail address:

	http://mithril.free.nf/verifyEmail.php?email='.$email.'&hash='.$hash;

    $mail->send();

    //Redirect
	header("Location: registered.php");
} catch (Exception $e) {
    echo "Error occurred while trying to send mail: ".$mail->ErrorInfo;
}
?>