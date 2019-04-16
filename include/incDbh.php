<?php
  $servername = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "webshop";

  $connection = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

  if(!$connection)
  {
    die("Connection to the DB failed.".mysqli_connect_error());
  }
