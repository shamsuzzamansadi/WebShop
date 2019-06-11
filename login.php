<?php
//   require "header.php";
//   require "products.php";
  // require_once "config.php";
  //require "include/incAuthentication.php";
  //require "include/incLogin.php";
?>
<html>
<head>
  <meta charset="utf-8">
    <link href="style.css" rel="stylesheet" type="text/css">

		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
  <div class="login">
			<h1>Login</h1>
			<form action="include/incAuthentication.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<a href="signup.php">Sign up</a>
				<input type="submit" value="Login">
			</form>
		</div>
</body>

</html>
<?php
  require "footer.php";
 ?>