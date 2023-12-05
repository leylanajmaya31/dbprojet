<?php

namespace App\Utils;

use PDO;
use PDOException;

class Connexion
{

    private static $instance = NULL;
    
    private ?PDO $conn = null; 

    static public function getInstance()
    {
        if (self::$instance === NULL) {
            try {
                self::$instance = new Connexion();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return self::$instance;
    }

    /*
     * Protected CTOR
     */
    protected function __construct()
    {
        include './env.php';
        $this->conn = new PDO('mysql:host='.$host.';dbname='.$database.'', $login, $password,);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }
}


