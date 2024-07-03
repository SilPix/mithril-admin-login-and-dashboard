<?php
$email = "e4luckygamer14@gmail.com"
$to = $email;
$subject = "Mithril | Verify your E-mail";
$msg = '
Brief Message
Or Multi-line message
';

$header = "From: " . $email . "\r\n" . "Reply-To: " . $email . "\r\n" . "X-Mailer:PHP/" . phpversion();
mail($to, $subject, $msg, $header);
?>