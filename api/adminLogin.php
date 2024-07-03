<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: 'Verdana';">
	<header style="font-family: 'Cambria';">
		<h1 style="text-align: center; font-size: 40px;">
			mithril-admin
		</h1>
	</header>

	<div></div>

	<section>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" style="padding: 40px; margin: 50px 500px; border: 2px solid black;">
			<h1 style="font-family: monospace;">Welcome Back, Administrator</h1>

			<br/> <br/>

			<label for="admin_id">Admin ID:</label><br/>
			<input type="text" id="admin_id" name="admin_id" placeholder="XXX-XXX" required><br/>

			<label for="password">Admin Password:</label><br/>
			<input type="password" id="admin_password" name="admin_password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required><br/>

			<?php
			//General ID & Password
			$admin_id = "ADR123";
			$admin_pw = "admin";
			$adm_check_1 = $adm_check_2 = false;

			//SQL Variables
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
				$sql = $conn->prepare("SELECT email, password FROM user_info");

				$sql->execute();

				$data = $sql->fetchAll();

				//Only allowed through is the given ID & Password matches our list
				if(isset($_POST['admin_id'])){
					foreach ($data as $row) {
						if($_POST['admin_id'] == $row['email']){
							$adm_check_1 = true;
						}
					}

					if($_POST['admin_id'] == $admin_id){
						$adm_check_1 = true;
					}

					if(!$adm_check_1){ echo "<br/>Error: Not an Administrator's ID <br/>"; }
				}

				if(isset($_POST['admin_password'])){
					foreach ($data as $row) {
						if($_POST['admin_password'] == $row['password']){
							$adm_check_2 = true;
						}
					}

					if($_POST['admin_password'] == $admin_pw){
						$adm_check_2 = true;
					}

					if(!$adm_check_2){ echo "Error: Not an Administrator's Password"; }
				}

				//Check that the Admin's Password matches his/her ID
				if(isset($_POST['admin_id']) && isset($_POST['admin_password'])){
					$sql = $conn->prepare("SELECT password FROM user_info WHERE email=:checkid");
					$sql->bindParam(":checkid", $_POST['admin_id']);
					$sql->execute();

					$data= null;
					$data = $sql->fetchAll();

					foreach($data as $row){
						//If given password doesn't match stored password
						if($_POST['admin_password'] != $row['password']){
							$adm_check_1 = $adm_check_2 = false;
							throw new Exception();	
						}
					}
				}

				if($adm_check_1 && $adm_check_2){
					//Mark user as authorized
					session_start();
					$_SESSION['authenticate'] = true;

					//Check for Super-Admin
					$_SESSION['admin_id'] = $_POST['admin_id'];
					$_SESSION['admin_password'] = $_POST['admin_password'];

					//Redirect
					header("Location: adminDashboard.php");
					exit;
				}
			} catch(PDOException $e){
				echo $sql . "<br/>" . $e->getMessage();
				$conn = null;
			} catch(Exception $e1){
				echo "<br/>The ID and Password do not match <br/>";
			}
			?>

			<br/> <br/>
			

			<input type="submit" value="Sign-in">
		</form>

		<p style="font-style: italics; text-align: center">Don't have an account? <a href="sign.php">Sign up</a></p>
	</section>

	<footer style="text-align: center; font-size:29px; font-family: 'Cambria';">
		Copyright &copy; 2024
	</footer>
</body>
</html>