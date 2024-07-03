<?php

$email = "e4luckygamer14@gmail.com";
$to = $email;
$subject = "Mithril | Verify your E-mail";
$msg = '
Brief Message
Or Multi-line message
';

$header = "From: " . $email . "\r\n" . "Reply-To: " . $email . "\r\n" . "X-Mailer:PHP/" . phpversion();
mail($to, $subject, $msg, $header);

if(mail($to, $subject, $msg, $header)){
    echo "Send Success\n";
}else{
    echo "Send Failure\n";
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/var/task/user/api/phpmailer/Exception.php';
require '/var/task/user/api/phpmailer/PHPMailer.php';
require '/var/task/user/api/phpmailer/SMTP.php';

$mail = new PHPMailer(true);

$fullname = 'Bro';
$email = "e4luckygamer14@gmail.com";
$hash = "dcg2rj3b3h";

try {
    // Server settings
    //$mail->setLanguage(CONTACTFORM_LANGUAGE);
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '52bc5350c6a3d7';
    $mail->Password = '015a7a5486692e';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 2525;

    // Recipients
    //$mail->isSendmail();
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
	//header("Location: registered.php");
} catch (Exception $e) {
    echo "Error occurred while trying to send mail: ".$mail->ErrorInfo;
}

?>