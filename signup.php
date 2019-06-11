<?php
  // require "header.php";
  // require "include/incAuthentication.php";
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
  <h1>Signup</h1>
    <form action="include/incSignup.php" method="post">
      <label for="signupName">
        <i class="fas fa-user"></i>
      </label>
      <input type="text" name="signupName" placeholder="Username">
      <label for="email">
        <i class="fas fa-email"></i>
      </label>
      <input type="text" name="email" placeholder="E-mail">
      <label for="password">
        <i class="fas fa-lock"></i>
      </label>
      <input type="password" name="password" placeholder="Password">
      <label for="passwordRepeat">
        <i class="fas fa-lock"></i>
      </label>
      <input type="password" name="passwordRepeat" placeholder="Repeat password">
      <input type="submit" name="btnSignup" value="Sign up"/>
    </form>
  </div>
</body>

<?php
  require "footer.php";
 ?>
