<?php

require_once '../recaptcha/src/autoload.php';

$server = 'localhost';
$username = "root";
$password = '';
$db = "users_task1";

try{
	//Using PDO, in 'exception' mode
	$conn = new PDO("mysql:host=$server; dbname=$db", $username, $password);
	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//Prepare SQL Statements
	$sql = $conn->prepare("SELECT email FROM user_info");
	$sql->execute();
	$emails = $sql->fetchAll();

	$sql = $conn->prepare("INSERT INTO user_info(name, email, phone, password) VALUES(:fullname, :email, :phoneNo, :pw)");

	$sql->bindParam(':fullname', $fullname);
	$sql->bindParam(':email', $email);
	$sql->bindParam(':phoneNo', $phoneNo);
	$sql->bindParam(':pw', $pw);

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

	$fullname = $_POST['fullname']; 
	$email = $_POST['email'];
	$phoneNo = $_POST['phone'];
	$pw = $_POST['password'];

	//Redirect to 'registered.php' if the recaptcha response is valid
	$sitekey = "6LeV7AEqAAAAAOjIdkmARBjbZKxGQ-UG7EMtz5hN";
	$secret = "6LeV7AEqAAAAAC6LcF1kavZxMvuCH73SEM182CH5";

	if($_POST['g-recaptcha-response']){
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		if($resp->isSuccess()){
			//Run SQL
			$sql->execute();
			header("Location: registered.php");
		}else{
			echo "You've encountered a CAPTCHA Error. Go back and redo the reCAPTCHA evaluation.";
			
			$resp->getErrorCodes();
		}
	}
	else{
		echo "You must perform the reCAPTCHA evaluation. Go back and try again.";
	}
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