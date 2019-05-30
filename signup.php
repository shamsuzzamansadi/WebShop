<?php
  require "header.php";
  require "include/incAuthenication.php";
?>

<main>
  <h1>Signup</h1>
  <form action="include/incSignup.php" method="post">
    <input type="text" name="signupName" placeholder="Username">
    <input type="text" name="email" placeholder="E-mail">
    <input type="password" name="password" placeholder="Password">
    <input type="password" name="passwordRepeat" placeholder="Repeat password">
    <button type="submit" name="btnSignup">Signup</button>
  </form>
</main>

<?php
  require "footer.php";
 ?>
