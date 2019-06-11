
<!DOCTYPE html>

<html>
  <head>
    <meta  charset="utf-8">
    <meta name="description" content="description">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>WebShop</title>
    <link href="bootstrap.css" rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  </head>
  <header>
      <body class="loggedin">
        <nav class="navtop">
          <div>
            <h1>
              <a href="index.php">
                FH WebShop
              </a>
            </h1>
            <?php

              if (session_status() == PHP_SESSION_NONE) {
                  session_start();
              }
              $count = 0;
              for ($i=1; $i < 4; $i++) { 
                  # code...
                  if (isset($_SESSION['cart_' . $i])) {
                      $count += $_SESSION['cart_' . $i]; 
                  }
              }
              $cart = <<<HTML
                <a href="cart.php"><i class="fas fa-shopping-cart"></i>{$count}</a>
HTML;
              echo $cart;
              if (isset($_SESSION['name'])) {
                $logout = <<<HTML
                <a href="profile.php"><i class="fas fa-user-circle"></i>{$_SESSION['name']}</a>
                <a href="include/incLogout.php"><i class="fas fa-sign-out-alt"></i>Log out</a>
HTML;
                echo $logout;
              }
              else {
                $login = <<<HTML
                <a href="login.php"><i class="fas fa-sign-in-alt"></i>Login</a>
HTML;
                  echo $login;
              }
            ?>
          </div>
        </nav>
        </header>

      <!-- <nav> -->
        <!-- <a href="#">
        </a>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Basket</a></li>
        </ul> -->

      <!-- </nav> -->

  </body>
</html>
