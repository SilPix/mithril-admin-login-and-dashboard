<?php

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
	$sql = $conn->prepare("INSERT INTO user_info(name, email, phone, password) VALUES(:fullname, :email, :phoneNo, :pw)");

	$sql->bindParam(':fullname', $fullname);
	$sql->bindParam(':email', $email);
	$sql->bindParam(':phoneNo', $phoneNo);
	$sql->bindParam(':pw', $pw);

	if($_POST['password'] == "admin"){
		throw new Exception();
	}

	$fullname = $_POST['fullname']; 
	$email = $_POST['email'];
	$phoneNo = $_POST['phone'];
	$pw = $_POST['password'];

	//Run SQL
	$sql->execute();

	//Redirect to 'registered.php'
	header("Location: registered.php");
} catch(PDOException $e){
	echo $sql . "<br/>" . $e->getMessage();
	$conn = null;
} catch(Exception $ep){
	echo "That password is reserved";
}

?>
