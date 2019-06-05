<?php
  // session_start();
  $servername = "localhost"; // server/host name
  $dbUsername = "user"; //username
  $dbPassword = "1234";
  $dbName = "webshop";

  $connection = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

  if(mysqli_connect_errno()) // If there is an error with the connection, stop the script and display the error.
  {
    die("Connection to the DB failed.".mysqli_connect_error());
  }

  