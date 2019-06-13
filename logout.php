<?php

include('util/UtilHelper.php');
use util\UtilHelper;

UtilHelper::removeCookie(UtilHelper::AUTH_COOKIE);
header('Location: login.php');
