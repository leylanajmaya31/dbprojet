<?php
    namespace App\Utils;
    class BddConnect{
        private $conn = null;
        //!fonction connexion BDD
        public function connexion(){
            //!import du fichier de configuration
            include './env.php';
            //!retour de l'objet PDO
            return new \PDO('mysql:host='.$host.';dbname='.$database.'', $login, $password, 
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        }
    }
?>
