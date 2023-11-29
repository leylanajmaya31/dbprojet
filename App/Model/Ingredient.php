<?php
namespace App\Model;
use App\Utils\BddConnect;
use App\Model\Recette;

class Ingredient extends BddConnect{
private ?int $id_ingredients;   
private ?string $nom_ingredient;

public function getIdIngredient(){
    return $this->id_ingredients;
}
public function setIdIngredient(?int $id):void{
    $this->id_ingredients = $id;
}
public function getNom(){
    return $this->nom_ingredient;
}
public function setNom(?string $nom):void{
    $this->nom_ingredient = $nom;
}


public function add(){
    try {
        $nom = $this->getNom();
        $req = $this->connexion()->prepare('INSERT INTO ingredients(nom_ingredient)
        VALUES (?)');
        $req->bindParam(1, $nom, \PDO::PARAM_STR);
        $req->execute();
    } catch (\Exception $e) {
        die('Error :'.$e->getMessage());
    } 
}

public function findOneBy(){
    try {
        $nom = $this->getNom();
        $req = $this->connexion()->prepare('SELECT ingredients.id_utilisateur, id_ingredient, nom_ingredient FROM ingredients 
        WHERE nom_ingredient = ?');
        $req->bindParam(1, $nom, \PDO::PARAM_STR);
        $req->setFetchMode(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Ingredient::class);
        $req->execute();
        return $req->fetch();
    } 
    catch (\Exception $e) {
        die('Error : '.$e->getMessage());
    }
}
}

