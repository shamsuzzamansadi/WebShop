<?php
    function update_basket($product_id, $amount, $user_id) {
        require 'incDbh.php';
        $sqlquery = "UPDATE tbl_basket SET amount = ? WHERE product_id = ? AND user_id = ? AND order_id IS NULL";
        $stmt = mysqli_stmt_init($connection);
        if(!$stmt->prepare($sqlquery))
        {
          header("Location: ../error.php");
          exit();
        }else {
          $stmt->bind_param("iii", $amount, $product_id, $user_id);
          $stmt->execute();
        //setcookie('cart_' . $i, '', time() - 3600, '/');
        }
    }

    function add_basket($product_id, $amount, $user_id) {
        require 'incDbh.php';
        $sqlquery = "SELECT * FROM tbl_basket WHERE product_id = ? AND user_id = ? AND order_id IS NULL";
        $stmt = mysqli_stmt_init($connection);
        if(!$stmt->prepare($sqlquery))
        {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else {
            $stmt->bind_param("ii", $product_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 1) {
              while($row = $result->fetch_assoc()) {
                $new_value = $amount + $row['amount'];
                update_basket($product_id, $new_value, $user_id);
                setcookie('cart_' . $i, '', time() - 3600, '/');
              }
            }
            else {
                $sqlquery = "INSERT INTO tbl_basket (product_id, amount, user_id) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($connection);
                if(!$stmt->prepare($sqlquery))
                {
                  header("Location: ../error.php");
                  exit();
                }else {
                  $stmt->bind_param("iii", $product_id, $amount, $user_id);
                  $stmt->execute();
                  setcookie('cart_' . $i, '', time() - 3600, '/');
                }
            }
        }
    }

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
            $user_id = (int) $row['id'];
            $_SESSION['id'] = $user_id;
            $_SESSION['name'] = $row['name'];
            if (count($_COOKIE) > 0) {
              for ($i=1; $i < 4; $i++) { 
                  # code...
                  if (isset($_COOKIE['cart_' . $i])) {
                      $quantity = (int) $_COOKIE['cart_' . $i];
                      add_basket($i, $quantity, $user_id);
                      setcookie('cart_' . $i, '', time() - 3600, '/');
                  }
              }
            }
            $sqlquery = "SELECT * FROM tbl_basket WHERE user_id = ? AND order_id IS NULL";
            $stmt = mysqli_stmt_init($connection);
            if(!$stmt->prepare($sqlquery))
            {
                header("Location: ../index.php?error=sqlerror");
                exit();
            }
            else {
              $stmt->bind_param("i", $user_id);
              $stmt->execute();
              $result = $stmt->get_result();
              if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $key = 'cart_' . $row['product_id'];
                  $_SESSION[$key] = $row['amount'];
                }
              }
            }
            $returnurl = rtrim($_POST['returnurl'], '/') ;
            header("Location: " . $returnurl);
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