<?php
include('data/UserAccess.php');
include('UtilHelper.php');
use util\UtilHelper;
use data\UserAccess;

$authUser = null;
$auth =  UtilHelper::getCookie(UtilHelper::AUTH_COOKIE);
if($auth != null) {    
    $userAccess = new UserAccess();
    $user = $userAccess->getbyToken($auth);
    $authUser = $user;
} else {
    header('Location: login.php');
}