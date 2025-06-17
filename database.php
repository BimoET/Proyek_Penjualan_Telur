<?php

class Database
{
    private $host = 'sql300.infinityfree.com';
    private $name = 'if0_39238712_db_telur';
    private $username = 'if0_39238712';
    private $password = 'UyIq7dJJuSsp';
    private $port = 3306;
    private $con;

    public function connection()
    { 
        $this->con = null;
    try{
        $this->con = new PDO(
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->name",
           $this->username,
            $this->password,
        );
        $this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $exception){
        echo "koneksi error ". $exception->getMessage();
    }
    return $this->con;
    }
}
?>