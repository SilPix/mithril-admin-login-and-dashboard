<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style>
		table{ width: 100% }
		table, th, td{
			border: 2px solid #000;
			padding: 1px; margin: 0;
		}
	</style>
</head>

<body style="font-family: 'Verdana';">
	<header style="font-family: 'Cambria';">
		<h1 style="text-align: center; font-size: 40px;">
			mithril-admin-dashboard
		</h1>
	</header>

	<div></div>

	<section style="padding: 40px; margin: 40px; border: 2px solid black;">
		<h1 style="font-family: monospace;">
			<?php 
			session_start();
			if(isset($_SESSION['authenticate'])){
				if($_SESSION['authenticate']){
					echo "Welcome Back, Administrator";
				}
			}
			else{
				echo "Error 403: Forbidden";
			}?>
		</h1>

		<br/> <br/>

		<table>
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
				$sql = $conn->prepare("SELECT name, email, phone FROM user_info");

				//Only run the SQL and fetch the data if the user is authentic
				if(isset($_SESSION['authenticate']) && $_SESSION['authenticate']){
					$sql->execute();

					$data = $sql->fetchAll();
					//$data = $conn->query($sql)->fetchAll(PDO::FETCH_BOTH);

					echo "
						<tr>
							<th>Name</th>
							<th>E-mail</th>
							<th>Phone Number</th>
						</tr>
					";

					foreach ($data as $row) {
						echo "<tr>";
						echo '<td>' . $row['name'] . '</td>';
						echo '<td>' . $row['email'] . '</td>';
						echo '<td>' . $row['phone'] . '</td>';
						echo "</tr>";
					}

					echo "Query Success";
				}
				elseif (!isset($_SESSION['authenticate']) || $_SESSION['authenticate'] == false) {
					echo "<tr><th>You are not allowed to view this page. If you are an admin and are seeing this message, contact IT Support.</th></tr>";
					echo "Query Failed";
				}
				session_destroy();

			} catch(PDOException $e){
				echo $sql . "<br/>" . $e->getMessage();
				$conn = null;
			}

			?>
		</table>

		<br/>

		<p style="font-style: italics; text-align: center">We really... really hope you're <a href="adminLogin.php">an Admin.</a></p>
	</section>

	<footer style="text-align: center; font-size:29px; font-family: 'Cambria';">
		Copyright &copy; 2024
	</footer>
</body>
</html>