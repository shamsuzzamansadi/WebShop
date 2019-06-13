<?php

namespace util;
class UtilHelper
{
    private const ONE_DAY = 86400; 
    public const AUTH_COOKIE = "Auth" ;

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    public static function verifyPassword($password, $storedPassword){
        return password_verify($password, $storedPassword);
    }

    public static function makeCookie($name, $content, $expiryInDays){
        $expiration = time() + (static::ONE_DAY * $expiryInDays);        
        setcookie($name, $content, $expiration, "/", "");        
    }

    public static function makeHttpOnlyCookie($name, $content, $expiryInDays){
        $expiration = time() + (static::ONE_DAY * $expiryInDays);        
        setcookie($name, $content, $expiration, "/", "", false, true);        
    }

    public static function unique(){
        return uniqid();
    }

    public static function getCookie($name){
        if(isset($_COOKIE[$name]))
           return $_COOKIE[$name];
        else
            return NULL;
    }
    public function exists($name){
        if(isset($_COOKIE[$name]))
        return TRUE;
     else
         return FALSE;
    }
    public static function removeCookie($name){
        if(isset($_COOKIE[$name]))
            setcookie($name, "", time() - static::ONE_DAY, "/", NULL);
            
    }
    public static function tokenGenerator($param1){
        $value = $param1.time().static::unique();
        return password_hash($value, PASSWORD_DEFAULT);
    }
    public static function getExpirayForDays($days){
        return time() + (static::ONE_DAY * $days);
    }
}
