<?php
if(isset($_POST['btnLogin']))
{
  require 'incDbh.php';

  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];
  if(empty($mailuid) || empty($password))
  {
    header("Location: ../index.php?error=emptyFields");
    exit();
  }
  else
  {
    $sqlquery = "SELECT * FROM users WHERE uid=? OR email=?";
    $stmt = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($stmt, $sqlquery))
    {
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else
    {
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $password);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if($row=mysqli_fetch_assoc($result))
      {
        $pwdCheck = password_verify($password, $row['pwd']);
        if($pwdCheck == false)
        {
          header("Location: ../index.php?error=wrongpwd");
          exit();
        }
        elseif($pwdCheck == true)
        {
          session_start();
          $_SESSION['id'] = $row['id'];
          $_SESSION['uid'] = $row['uid'];

          header("Location: ../index.php?login=success");
          exit();
        }
        else{
          header("Location: ../index.php?error=wrongpwd");
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
  header("Location: ../signup.php");
  exit();
}
?>
