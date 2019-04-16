<!DOCTYPE html>
<html>
  <head>
    <meta  charset="utf-8">
    <meta name="description" content="description">
    <meta name=viewport content="width=device-width, initial-scale=1"
    <title></title>
  </head>
  <body>
    <header>
      <nav>
        <a href="#">
        </a>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Warenkorb</a></li>
        </ul>
        <div>
          <form action="include/incLogin.php" methid="post">
            <input type="text" name="mailuid" placeholder="Username/E-mail">
            <input type="password" name="pwd" placeholder="password">
            <button type="submit" name="btnLogin">Login</button>
          </form>
          <a href="signup.php">Signup</a>
          <form action="include/incLogout.php" method="post">
            <button type="submit" name="btnLogout">Logout</button>
          </form>
        </div>
      </nav>
    </header>
  </body>
</html>
