<?php
  if (isset($_POST['username']) && isset($_POST['password']))
  {
    require 'incDbh.php';

    $loginName = $_POST['username'];
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
          $pwdCheck = password_verify($password, $row['password']);
          if($pwdCheck == false)
          {
            header("Location: ../index.php?error=wrongpwd");
            exit();
          }
          elseif($pwdCheck == true)
          {
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];

            header("Location: ../index.php");
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