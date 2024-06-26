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

			<label for="email">Admin ID:</label><br/>
			<input type="text" id="unique" name="unique" placeholder="XXX-XXX" required><br/>

			<label for="password">Admin Password:</label><br/>
			<input type="password" id="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required><br/>

			<?php
			$admin_pw = "admin";

			if(isset($_POST['password'])){
				if($_POST['password'] == $admin_pw){
					header("Location: adminDashboard.php");
				}
				elseif($_POST['password'] != $admin_pw){
					echo "Error: Not an Administrator's Password";
				}
			}
			?>

			<br/> <br/>
			

			<input type="submit" value="Sign-in">
		</form>

		<p style="font-style: italics; text-align: center">Don't have an account? <a>Sign up</a></p>
	</section>

	<footer style="text-align: center; font-size:29px; font-family: 'Cambria';">
		Copyright &copy; 2024
	</footer>
</body>
</html>