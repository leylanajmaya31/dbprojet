<?php
namespace App\Model;
use App\Utils\Connexion;
use App\Model\Role;
class Utilisateur{
    //attributs
    private ?int $id_utilisateur;
    private ?string $nom_utilisateur;
    private ?string $prenom_utilisateur;
    private ?string $email_utilisateur;
    private ?string $mdp_utilisateur;
    private ?string $image_utilisateur;
    private ?bool $statut_utilisateur;
    private Role $role;
    public function __construct(){
        $this->role = new Role();
    }

    
    //!Getters et Setters
    public function getId():?int{
        return $this->id_utilisateur;
    }
    public function setId(?int $id){
        $this->id_utilisateur = $id;
    }
    public function getNomUtilisateur():?string{
        return $this->nom_utilisateur;
    }
    public function setNomUtilisateur(?string $nom){
        $this->nom_utilisateur = $nom;
    }
    public function getPrenom():?string{
        return $this->prenom_utilisateur;
    }
    public function setPrenom(?string $prenom){
        $this->prenom_utilisateur = $prenom;
    }
    public function getEmail():?string{
        return $this->email_utilisateur;
    }
    public function setEmail(?string $email){
        $this->email_utilisateur = $email;
    }
    public function getMdp():?string{
        return $this->mdp_utilisateur;
    }
    public function setMdp(?string $mdp){
        $this->mdp_utilisateur = $mdp;
    }
    public function getImage():?string{
        return $this->image_utilisateur;
    }
    public function setImage(?string $image){
        $this->image_utilisateur = $image;
    }
    public function getStatut():?bool{
        return $this->statut_utilisateur;
    }
    public function setStatut(?bool $statut){
        $this->statut_utilisateur = $statut;
    }
    public function getRole():?Role{
        return $this->role;
    }
    public function setRole(?Role $role){
        $this->role = $role;
    }
    //!Méthodes
    public function add(){
        try {
            //!récupérer les données de l'objet
            $nom = $this->nom_utilisateur;
            $prenom = $this->prenom_utilisateur;
            $email = $this->email_utilisateur;
            $mdp = $this->mdp_utilisateur;
            $image = $this->image_utilisateur;
            $statut = $this->statut_utilisateur;
            $req = Connexion::getInstance()->getConn()->prepare(
                "INSERT INTO utilisateur(nom_utilisateur, prenom_utilisateur, 
                email_utilisateur, mdp_utilisateur, image_utilisateur, statut_utilisateur) VALUES(?,?,?,?,?,?)");
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->bindParam(2, $prenom, \PDO::PARAM_STR);
            $req->bindParam(3, $email, \PDO::PARAM_STR);
            $req->bindParam(4, $mdp, \PDO::PARAM_STR);
            $req->bindParam(5, $image, \PDO::PARAM_STR);
            $req->bindParam(6, $statut, \PDO::PARAM_BOOL);
            $req->execute();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

    public function findOneBy(){
        try {
            //!récupérer les données de l'objet
            $mail = $this->email_utilisateur;
            $req = Connexion::getInstance()->getConn()->prepare(
                "SELECT id_utilisateur, nom_utilisateur, prenom_utilisateur, 
                email_utilisateur, mdp_utilisateur, statut_utilisateur, image_utilisateur 
                FROM utilisateur WHERE email_utilisateur = ?");
            $req->bindParam(1, $mail, \PDO::PARAM_STR);
            $req->setFetchMode(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Utilisateur::class);
            $req->execute();
            return $req->fetch();
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    public function findAll(){
        try {
            $id = $this->getId();
            $req = Connexion::getInstance()->getConn()->prepare(
                "SELECT id_utilisateur, nom_utilisateur, prenom_utilisateur, 
                email_utilisateur, image_utilisateur FROM utilisateur WHERE id_utilisateur != ?");
            $req->bindParam(1, $id, \PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Utilisateur::class);
        } catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    public function update(){
        try {
            $email = $this->email_utilisateur;
            $req = Connexion::getInstance()->getConn()->prepare('UPDATE utilisateur SET 
            statut_utilisateur = true WHERE email_utilisateur = ?');
            $req->bindParam(1, $email, \PDO::PARAM_STR);
            $req->execute();
        } 
        catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
}
?> 