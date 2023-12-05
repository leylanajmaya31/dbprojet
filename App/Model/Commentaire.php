<?php
namespace App\Model;
use App\Model\Utilisateur;
use App\Model\Recette;
use App\Utils\Connexion;
class Commentaire {
    /*---------------------------------
                Attributs
    ---------------------------------*/
    private ?int $id_commentaire;
    private ?int $commentaire_commenter;
    private ?bool $statut_commenter;
    private ?string $date_commenter;
    private ?Utilisateur $auteur_commentaire;
    private ?Recette $recette_commentaire;
    /*---------------------------------
                Constructeur
    ---------------------------------*/
    public function __construct(){
        $this->auteur_commentaire = new Utilisateur();
        $this->recette_commentaire = new Recette();
    }
    /*---------------------------------
                Getters et Setters
    ---------------------------------*/
    public function getId():?int{
        return $this->id_commentaire;
    }
    public function setId(?int $id){
        $this->id_commentaire = $id;
    }
    public function getCommentaire():?int{
        return $this->commentaire_commenter;
    }
    public function setCommentaire(?int $commentaire){
        $this->commentaire_commenter = $commentaire;
    }

    public function getStatut():?bool{
        return $this->statut_commenter;
    }
    public function setStatut(?bool $statut){
        $this->statut_commenter = $statut;
    }
    public function getDate():?string{
        return $this->date_commenter;
    }
    public function setDate(?string $date){
        $this->date_commenter = $date;
    }
    public function getAuteur():?Utilisateur{
        return $this->auteur_commentaire;
    }
    public function setAuteur(?Utilisateur $auteur){
        $this->auteur_commentaire = $auteur;
    }
    public function getRecette():?Recette{
        return $this->recette_commentaire;
    }
    public function setRecette(?Recette $recette){
        $this->recette_commentaire = $recette;
    }
    /*---------------------------------
                Méthodes
    ---------------------------------*/
    public function add(){
        try {
            $commentaire = $this->commentaire_commenter;
            $statut = $this->statut_commenter;
            $date = $this->date_commenter;
            $auteur = $this->auteur_commentaire->getId();
            $recette = $this->recette_commentaire->getId();
            $req = Connexion::getInstance()->getConn()->prepare('INSERT INTO commenter(
                commentaire_commenter, statut_commentaire, date_commenter,
                id_utilisateur, id_recette) VALUES(?,?,?,?,?)');
            $req->bindParam(1, $commentaire, \PDO::PARAM_INT);
            $req->bindParam(2, $statut, \PDO::PARAM_BOOL);
            $req->bindParam(3, $date, \PDO::PARAM_INT);
            $req->bindParam(4, $auteur, \PDO::PARAM_INT);
            $req->bindParam(5, $recette, \PDO::PARAM_INT);
            $req->execute();
        } 
        catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    public function findBy(){
        try {
            $id = $this->getRecette()->getIdRecette();
            $req = Connexion::getInstance()->getConn()->prepare('SELECT id_commentaire, commentaire_commenter,
            prenom_utilisateur, nom_utilisateur, id_recette FROM commentaire_commenter
            INNER JOIN utilisateur  ON commentaire.auteur_commentaire = utilisateur.id_utilisateur
            WHERE id_recette = ?');
            $req->bindParam(1, $id, \PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Commentaire::class);
        } catch (\Exception $e) {
        }
    }
}