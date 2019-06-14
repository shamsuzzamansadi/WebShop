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
		<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
</head>
<body>
  <div class="login">
			<h1>Login</h1>
			<form action="include/incAuthentication.php" method="post">
				<label for="username">
					<i class="fa fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fa fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<a href="signup.php">Sign up</a>
				<?php
					$return_url = $_SERVER["HTTP_REFERER"];
				    $cart = <<<HTML
						<input type="text" hidden name="returnurl" value=$return_url/>
HTML;
					echo $cart;
				?>
				<input type="submit" value="Login">
			</form>
		</div>
</body>

</html>
<?php
  require "footer.php";
 ?>