<?php
namespace App\Model;
use App\Utils\BddConnect;
class Role extends BddConnect{
    //!Attributs
    private ?int $id_role;
    private ?string $nom_role;
    //!constructeur
    //!Getters et Setters
    public function getId():?int{
        return $this->id_role;
    }
    public function setId(?int $id){
        $this->id_role = $id;
    }
    public function getNom():?string{
        return $this->nom_role;
    }
    public function setNom(?string $nom){
        $this->nom_role = $nom;
    }
    //!Méthodes
    //!Ajouter un roles en BDD
    public function add(){
        try {
            $nom = $this->getNom();
            $req = $this->connexion()->prepare('INSERT INTO role(nom_role)VALUES(?)');
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->execute();
        } 
        catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    //!Chercher un roles par son nom en BDD
    public function findOneBy(){
        try {
            $nom = $this->getNom();
            $req = $this->connexion()->prepare('SELECT id_role, nom_role FROM
            role WHERE nom_role = ?');
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->execute();
            $req->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Role::class);
            return $req->fetch();
        } 
        catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
}
?>