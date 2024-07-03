<?php
$email = "e4luckygamer14@gmail.com"
$to = $email;
$subject = "Mithril | Verify your E-mail";
$msg = '
Brief Message
Or Multi-line message
';

$header = "From:noreply@mithril-reg.vercel.app";
mail($to, $subject, $msg, $header);
?>