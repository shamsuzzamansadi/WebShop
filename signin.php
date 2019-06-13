<?php
include("views/header.php");
include('util/UtilHelper.php');
include('data/UserAccess.php');

use util\UtilHelper;
use data\UserAccess;
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "1";
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        echo "2";
        $email = $_POST["email"];
        $password = $_POST["password"];

        if ($email && $password) {
            $userAccess = new UserAccess();
            $password = UtilHelper::hashPassword($password);
            echo $password;
            $userAccess->create("", "", $email, $password);
            header('Location: login.php');
        } else {
            header('Location: signin.php');
        }
    } else {
        header('Location: signin.php');
    }
}
?>



<br />
<br />
<br />
<br />
<br />
<br />


<div class="card">
    <div class="card-header">
        SignIn
    </div>
    <div class="card-body">

        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">SignIn</button>
        </form>
    </div>
</div>


<?php
include("views/footer.php");
?>