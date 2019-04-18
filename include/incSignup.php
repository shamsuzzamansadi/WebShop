<?php
  if (isset($_POST['btnSignup'])) {
    require 'incDbh.php';
    $username = $_POST['signupName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];

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
      $sqlquery = "SELECT Name FROM users WHERE Name=?";
      $stmt = mysqli_stmt_init($connection);

      if(!$stmt->prepare($sqlquery))
      {
        header("Location: ../signup.php?error=sqlerror");
        exit();
      }
      else{
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $resultCheck = $stmt->num_rows();
        if($resultCheck>0)
        {
          header("Location: ../signup.php?usertaken&mail=".$email);
          exit();
        }
        else
        {
          $sqlquery = "INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)";
          $stmt = mysqli_stmt_init($connection);
          if(!$stmt->prepare($sqlquery))
          {
            header("Location: ../signup.php?error=sqlerror");
            exit();
          }else {
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $username, $email, $hashedPwd);
            $stmt->execute();
            header("Location: ../signup.php?signup=success");
            exit();
          }
        }
      }

    }
    $stmt->close();
    $connection->close();

  }
  else{
    header("Location: ../signup.php");
    exit();
  }
