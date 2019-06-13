<?php
namespace data;
include('DBManager.php');
class UserAccess {
    public function create($firstname, $lastname, $email, $password) {
        $dbManager = new DBManager();
        $dbManager->executeQuery("INSERT INTO shopdb.user (firstname, lastname, email, password, token, attempts) 
        VALUES ('$firstname', '$lastname', '$email', '$password', '', 0)");
    }
    public function createWithToken($firstname, $lastname, $email, $password, $token) {        
        $dbManager = new DBManager();
        $dbManager->executeQuery("INSERT INTO shopdb.user (firstname, lastname, email, password, token, attempts) 
        VALUES ('$firstname', '$lastname', '$email', '$password', '$token', 0)");
    }
    public function ExistsByEmailPassword($email, $password) {        
        $dbManager = new DBManager();
        $query = "SELECT * FROM shopdb.user WHERE email = '$email' AND password = '$password'";
        echo $query;
        $result = $dbManager->executeQuery($query);
        if($row = $result->fetch_assoc()) {
            return true;
        } else {
            return false;
        }
    }
    public function getbyToken($token) {             
        $dbManager = new DBManager();
        $result = $dbManager->executeQuery("SELECT * FROM shopdb.user where token = '$token'");
        $row = $result->fetch_assoc();
        if($row) {            
            return $row;
        } else {            
            return null;
        }        
    }

    public function getbyEmail($email) {             
        $dbManager = new DBManager();
        $result = $dbManager->executeQuery("SELECT * FROM shopdb.user where email = '$email'");
        $row = $result->fetch_assoc();
        if($row) {            
            return $row;
        } else {            
            return null;
        }        
    }
    
    public function updateToken($email, $token) {        
        $dbManager = new DBManager();
        $dbManager->executeQuery("UPDATE shopdb.user SET token = '$token' WHERE email = '$email'");
    }
}