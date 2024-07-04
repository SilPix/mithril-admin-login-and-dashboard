<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body style="font-family: 'Verdana';">
	<header style="font-family: 'Cambria';">
		<h1 style="text-align: center; font-size: 40px;">
			mithril-musk-maeve
		</h1>
	</header>

	<div></div>

	<section class="">
		<form method="post" action="handleForm.php" style="padding: 40px; margin: 50px 500px; border: 2px solid black;">
			<h1 class="">Welcome!</h1>

			<br/> <br/>

			<label for="email">Name:</label><br/>
			<input type="text" id="fullname" name="fullname" placeholder="John Doe" required><br/><br/>

			<label for="email">E-mail Address:</label><br/>
			<input type="email" id="email" name="email" placeholder="yourname@gmail.com" required><br/><br/>

			<label for="email">Phone Number:</label><br/>
			<input type="text" id="phone" name="phone" placeholder="+234-(XXX)-(XXXX)" required><br/><br/>

			<label for="password">Your Password:</label><br/>
			<input type="password" id="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required><br/>

			<br/> <br/>
			
			<!-- reCAPTCHA -->
			<div class="g-recaptcha" data-sitekey="6LeV7AEqAAAAAOjIdkmARBjbZKxGQ-UG7EMtz5hN"></div>

			<br/>
			<input type="submit" value="Register">
		</form>

		<p style="font-style: italics; text-align: center">Already have an account? <a href="adminLogin.php">Sign in</a></p>
	</section> 

	<footer style="text-align: center; font-size:29px; font-family: 'Cambria';">
		Copyright &copy; 2024
	</footer>
</body>
</html>