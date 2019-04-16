<?php
  if (isset($_POST['btnSignup'])) {
    require 'incDbh.php';
    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    if (empty($username) ||
    empty($email) ||
    empty($password) ||
    empty($passwordRepeat)) {
      header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      header("Location: ../signup.php?error=invalidmail&uid");
      exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      header("Location: ../signup.php?error=invalidmail&uid=".$username);
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
      header("Location: ../signup.php?error=invaliduid&mail=".$email);
      exit();
    }
    elseif($password !== $passwordRepeat)
    {
      header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
      exit();
    }
    else {
      $sqlquery = "SELECT uid FROM users WHERE uid=?";
      $stmt = mysqli_stmt_init($connection);

      if(!mysqli_stmt_prepare($stmt, $sqlquery))
      {
        header("Location: ../signup.php?error=sqlerror");
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if($resultCheck>0)
        {
          header("Location: ../signup.php?usertaken&mail=".$email);
          exit();
        }
        else
        {
          $sqlquery = "INSERT INTO users (uid, email, pwd) VALUES (?, ?, ?)";
          $stmt = mysqli_stmt_init($connection);
          if(!mysqli_stmt_prepare($stmt, $sqlquery))
          {
            header("Location: ../signup.php?error=sqlerror");
            exit();
          }else {
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
            mysqli_stmt_execute($stmt);
            header("Location: ../signup.php?signup=success");
            exit();
          }
        }
      }

    }
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

  }
  else{
    header("Location: ../signup.php");
    exit();
  }
