<?php
namespace data;

class DBManager
{
    private $connection;
    private static $username = "user";
    private static $password = "1234";
    private static $hostname = "";
    private static $database = "shopdb";
    public function prepareConnection()
    {
        $this->connection = new \mysqli(
            static::$hostname,
            static::$username,
            static::$password,
            static::$database
        );
    }
    public function getConnection()
    {
        if ($this->connection) {
            $this->prepareConnection();
        }
        return $this->connection;
    }
    public function close()
    {
        if ($this->connection == true) {            
            $this->connection->close();
            $this->connection = NULL;
        }
    }
    public function executeQuery($query)
    {
        try {
            if ($this->connection == null) {
                $this->prepareConnection();
                return $this->connection->query($query);
            }
        } catch (Exception $ex) {            
        } finally {
            $this->close();
        }
    }    
    public function executeCommand($query)
    {
        try {
            if ($this->connection == null) {                
                $this->prepareConnection();
            }
            if ($this->connection->query($query) == true) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        } finally {
            $this->close();
        }
    }
    public function executeInitiationCommand($query)
    {
        $connection = new \mysqli(
            static::$hostname,
            static::$username,
            static::$password
        );
        try {
            if ($connection->query($query) == true) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        } finally {
            $connection->close();
        }
    }
}