<?php

require_once './recaptcha/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/Exception.php';
require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';

$server = 'sql.example-server.com';
$username = "username";
$password = 'password';
$db = "sql_database_name";

try{
	//Using PDO, in 'exception' mode
	$conn = new PDO("mysql:host=$server; dbname=$db", $username, $password);
	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//Prepare SQL Statements
	$sql = $conn->prepare("SELECT email FROM user_info");
	$sql->execute();
	$emails = $sql->fetchAll();

	$sql = $conn->prepare("INSERT INTO user_info(name, email, phone, password, hash, verified) VALUES(:fullname, :email, :phoneNo, :pw, :hash, :vfd)");

	$sql->bindParam(':fullname', $fullname);
	$sql->bindParam(':email', $email);
	$sql->bindParam(':phoneNo', $phoneNo);
	$sql->bindParam(':pw', $pw);
	$sql->bindParam(':hash', $hash);
	$sql->bindParam(':vfd', $vfd);

	if($_POST['password'] == "admin"){
		//Password 'admin' reserved for "Super-Admin"
		throw new Exception('p');
	}

	foreach ($emails as $row) {
		if($_POST['email'] == $row['email']){
			//Must not match an existing email
			throw new Exception('e');
		}
	}

	//Set Values from the form as the values to store into the DB
	$fullname = $_POST['fullname']; 
	$email = $_POST['email'];
	$phoneNo = $_POST['phone'];
	$pw = $_POST['password'];

	//Random String for Account Verification
	$hash = md5(rand(0,1000));
	$vfd = 'n';

	//Redirect to 'registered.php' if the recaptcha response is valid
	$sitekey = "f7177163c833dff4b38fc8d2872f1ec6";
	$secret = "e744f91c29ec99f0e662c9177946c627";

	if($_POST['g-recaptcha-response']){
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		if($resp->isSuccess()){
			//Run SQL
			$sql->execute();

			//Send Verification E-mail
			$mail = new PHPMailer(true);

			try {
				// Server settings
				$mail->SMTPDebug = 2;
				$mail->isSMTP();
				$mail->Host = 'sandbox.smtp.mailtrap.io';
				$mail->SMTPAuth = true;
				$mail->Username = 'p';
				$mail->Password = 'e';
				$mail->SMTPSecure = 'tls';
				$mail->Port = 2525;

				// Recipients
				$mail->setFrom('noreply@mithril.free.nf', 'Mithril-Registry');
				$mail->addAddress($email);
				$mail->IsHTML(true);

				// Content
				$mail->Subject = "Mithril | Verify your E-mail";
				$mail->Body = '<div style="padding:10px; margin:5px; border:2px solid #000;"><h1>Mithril Registry Inc.</h1><br/>
				Thank you <strong>' . $fullname . '</strong> for registering. There is one more step before your account is activated.<br/>
				Please click on the link below to verify your E-mail address:<br/> <br/>

				<a href="http://mithril.free.nf/verifyEmail.php?email='.$email.'&hash='.$hash.'">
				http://mithril.free.nf/verifyEmail.php?email='.$email.'&hash='.$hash.'</a></div>';

			    $mail->send();

			    //Redirect
				header("Location: registered.php");
			} catch (Exception $e) {
			    echo "Error occurred while trying to send mail: ".$mail->ErrorInfo;
			}

			//Redirect
			//header("Location: registered.php");
		}else{
			echo "You've encountered a CAPTCHA Error. Go back and redo the reCAPTCHA evaluation.";
			
			$resp->getErrorCodes();
		}
	}
	else{
		echo "You must perform the reCAPTCHA evaluation. Go back and try again.";
	}
	//header("Location: registered.php");
} catch(PDOException $e){
	echo $sql . "<br/>" . $e->getMessage();
	$conn = null;
} catch(Exception $ep){
	if($ep->getMessage() == 'p'){
		echo "That password is reserved";
	}
	if($ep->getMessage() == 'e'){
		echo "Your E-mail has been previously used";
	}
}

?>
