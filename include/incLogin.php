<?php
  if (isset($_POST['btnLogin']))
  {
    require 'incDbh.php';

    $loginName = $_POST['loginName'];
    $password = $_POST['password'];
    if(empty($loginName) || empty($password))
    {
      header("Location: ../index.php?error=emptyFields");
      exit();
    }
    else
    {
      $sqlquery = "SELECT * FROM tbl_users WHERE name=? OR email=?";
      $stmt = mysqli_stmt_init($connection);
      if(!$stmt->prepare($sqlquery))
      {
        header("Location: ../index.php?error=sqlerror");
        exit();
      }
      else
      {
        $stmt->bind_param("ss", $loginName, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row=$result->fetch_assoc())
        {
          $pwdCheck = password_verify($password, $row['Password']);
          if($pwdCheck == false)
          {
            header("Location: ../index.php?error=wrongpwd");
            exit();
          }
          elseif($pwdCheck == true)
          {
            session_start();
            $_SESSION['Id'] = $row['Id'];
            $_SESSION['Name'] = $row['Name'];

            header("Location: ../index.php?login=success");
            exit();
          }
        }
        else
        {
          header("Location: ../index.php?error=nouser");
          exit();
        }
      }
    }
  }
  else
  {
    header("Location: ../index.php");
    exit();
  }
