<?php
namespace App\Model;
use App\Utils\Connexion;

class Ingredient{
private ?int $id_ingredients;   
private ?string $nom_ingredient;
private ?int $quantite_ingredient;
private ?string $unite_ingredient;

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
public function getQuantite(){
    return $this->quantite_ingredient;
}
public function setQuantite(?int $quantite):void{
    $this->quantite_ingredient = $quantite;
}
public function getUnite(){
    return $this->unite_ingredient;
}
public function setUnite(?string $unite):void{
    $this->unite_ingredient = $unite;
}

public function addIngredient(){
    try {
        $nom = $this->getNom();
        $quantite = $this->getQuantite(); 
        $unite = $this->getUnite();
        $conn = Connexion::getInstance()->getConn();
        $req = $conn->prepare ('INSERT INTO ingredients(nom_ingredient, quantite_ingredient, unite_ingredient)
        VALUES (?,?,?)');
        $req->bindParam(1, $nom, \PDO::PARAM_STR);
        $req->bindParam(2, $quantite, \PDO::PARAM_INT);
        $req->bindParam(3, $unite, \PDO::PARAM_STR);
        $req->execute();
        $this->id_ingredients = $conn->lastInsertId();
    } catch (\Exception $e) {
        die('Error :'.$e->getMessage());
    } 
}



public function addIngredientToRecette($idRecette) {
    //dd($this);
    try {
        $idIngredient = $this->getIdIngredient();

        if ($idIngredient) {
            $conn = Connexion::getInstance()->getConn();
            $req = $conn->prepare('INSERT INTO renseigner(id_recette, id_ingredients) VALUES (?, ?)');
            $req->bindParam(1, $idRecette, \PDO::PARAM_INT);
            $req->bindParam(2, $idIngredient, \PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_ASSOC);
        }
    } catch (\Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


public function findOneBy(){
    try {
        $nom = $this->getNom();
        $req = Connexion::getInstance()->getConn()->prepare('SELECT id_ingredient, nom_ingredient FROM ingredients WHERE nom_ingredient = ?');
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