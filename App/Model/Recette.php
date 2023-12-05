<?php
namespace App\Model;
use App\Model\Utilisateur;
use App\Utils\Connexion;
class Recette {
    /*---------------------------- 
                Attributs
    -----------------------------*/
    private ?int $id_recette;
    private ?string $nom_recette;
    private ?string $niveau_recette;
    private ?string $date_recette;
    private ?int $portion_recette;
    private ?string $temps_recette;
    private ?bool $statut_recette = null;
    private ?string $description_recette;
    private ?string $image_recette = null;
    private ?string $unite_recette = null;
    private ?Utilisateur $auteur_recette;

    public function __construct(){
        $this->auteur_recette = new Utilisateur();
    }
    
    /*---------------------------- 
            Getters et Setters
    -----------------------------*/
    public function getIdRecette(){
        return $this->id_recette;
    }
    public function setIdRecette(?int $id):void{
        $this->id_recette = $id;
    }
    public function getNom():?string{
        return $this->nom_recette;
    }
    public function setNom(?string $nom):void{
        $this->nom_recette = $nom;
    }
    public function getNiveau():?string{
        return $this->niveau_recette;
    }
    public function setNiveau(?string $niveau):void{
        $this->niveau_recette = $niveau;
    }
    public function getDate():?string{
        return $this->date_recette;
    }
    public function setDate(?string $date):void{
        $this->date_recette = $date;
    }
    public function getPortion():?int{
        return $this->portion_recette;
    }
    public function setPortion(?int $portion):void{
        $this->portion_recette = $portion;
    }
    
    public function getTemps():?string{
        return $this->temps_recette;
    }
    public function setTemps(?string $temps):void{
        $this->temps_recette = $temps;
    }
    public function getStatut():?bool{
        return $this->statut_recette;
    }
    public function setStatut(?bool $statut):void{
        $this->statut_recette = $statut;
    }
    public function getDescription():?string{
        return $this->description_recette;
    }
    public function setDescription(?string $description):void{
        $this->description_recette = $description;
    }
    public function getImage():?string{
        return $this->image_recette;
    }
    public function setImage(?string $image):void{
        $this->image_recette = $image;
    }

    public function getAuteur():?Utilisateur {
        return $this->auteur_recette;
    }

    public function setAuteur(?Utilisateur $auteur): void { //voïd ne retourne rien evite les erreurs
        $this->auteur_recette = $auteur;
    }
    public function getUnite(): ?string {
        return $this->unite_recette;
    }

    public function setUnite(?string $unite): void {
        $this->unite_recette = $unite;
    }


    /*---------------------------- 
                Méthodes
    -----------------------------*/
    public function add(){
        try {
            $nom = $this->getNom();
            $date = $this->getDate();
            $niveau = $this->getNiveau();
            $description = $this->getDescription();
            $portion = $this->getPortion();
            $temps = $this->getTemps();
            $image = $this->getImage();
            $statut = !empty($this->getStatut()); //permet de convertir  false si c'est null
            $unite = $this->getUnite();
            $auteur = $this->getAuteur()->getId();
            $conn = Connexion::getInstance()->getConn();
            $req = $conn->prepare ('INSERT INTO recette(nom_recette, date_recette,
                niveau_recette, description_recette, portion_recette, temps_recette, image_recette, statut_recette, unite_recette, auteur_recette)
                VALUES (?,?,?,?,?,?,?,?,?,?)');
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->bindParam(2, $date, \PDO::PARAM_STR);
            $req->bindParam(3, $niveau, \PDO::PARAM_STR);
            $req->bindParam(4, $description, \PDO::PARAM_STR);
            $req->bindParam(5, $portion, \PDO::PARAM_INT);
            $req->bindParam(6, $temps, \PDO::PARAM_STR);
            $req->bindParam(7, $image, \PDO::PARAM_STR);
            $req->bindParam(8, $statut, \PDO::PARAM_BOOL);
            $req->bindParam(9, $unite, \PDO::PARAM_STR);
            $req->bindParam(10, $auteur, \PDO::PARAM_INT); // Utilisez l'id de l'auteur
            $req->execute();
            // Récupérez l'ID de la dernière insertion
            $this->id_recette = $conn->lastInsertId();
            return $this->id_recette; // Retourne l'ID de la recette nouvellement ajoutée
        } catch (\Exception $e) {
            die('Error :'.$e->getMessage());
        } 
    }

    // Rechercher une recette
    public function findOneBy(){
        try {
            $nom = $this->getNom();
            $date = $this->getDate();
            $niveau = $this->getNiveau();
            $description = $this->getDescription();
            $portion = $this->getPortion();
            $unite = $this->getUnite();
            $temps = $this->getTemps();
            $image = $this->getImage();
            $statut = $this->getStatut();
            $auteur = $this->getAuteur()->getId();
            $req = Connexion::getInstance()->getConn()->prepare("SELECT id_recette, nom_recette,
            date_recette, niveau_recette, description_recette, portion_recette, unite_recette, temps_recette, image_recette, statut_recette, auteur_recette FROM recette 
            WHERE nom_recette = ? AND date_recette = ? AND niveau_recette = ? AND 
            description_recette = ? AND portion_recette = ? AND unite_recette = ? AND temps_recette = ? AND image_recette = ?  AND statut_recette = ? AND auteur_recette = ?");
            $req->bindParam(1, $nom, \PDO::PARAM_STR);
            $req->bindParam(2, $date, \PDO::PARAM_STR);
            $req->bindParam(3, $niveau, \PDO::PARAM_STR);
            $req->bindParam(4, $description, \PDO::PARAM_STR);
            $req->bindParam(5, $portion, \PDO::PARAM_INT);
            $req->bindParam(6, $unite, \PDO::PARAM_STR);
            $req->bindParam(7, $temps, \PDO::PARAM_STR);
            $req->bindParam(8, $image, \PDO::PARAM_STR);
            $req->bindParam(9, $statut, \PDO::PARAM_BOOL);
            $req->bindParam(10, $auteur, \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_CLASS| \PDO::FETCH_PROPS_LATE, Recette::class);
            $req->execute();
            return $req->fetch();
        } 
        catch (\Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }

    // Afficher la liste des recettes
    public function findAll() {
        try {
            $req = Connexion::getInstance()->getConn()->prepare('
                SELECT 
                    recette.id_recette, 
                    recette.nom_recette, 
                    recette.date_recette, 
                    recette.niveau_recette, 
                    recette.description_recette, 
                    recette.portion_recette, 
                    recette.unite_recette,
                    recette.temps_recette, 
                    recette.image_recette, 
                    recette.statut_recette, 
                    utilisateur.nom_utilisateur AS nom_auteur, 
                    utilisateur.prenom_utilisateur AS prenom_auteur,
                    utilisateur.image_utilisateur AS image_auteur
                FROM recette
                INNER JOIN utilisateur ON recette.auteur_recette = utilisateur.id_utilisateur');
            $req->execute();
            return $req->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            die('Error : ' . $e->getMessage());
        }
    }


}
//     public function find($id_recette) {
//         try {
//             $req = Connexion::getInstance()->getConn()->prepare("SELECT 
//                 recette.id_recette, recette.nom_recette, recette.date_recette, 
//                 recette.niveau_recette, recette.description_recette, recette.portion_recette, recette.unite_recette,
//                 recette.temps_recette, recette.image_recette, recette.statut_recette, recette.auteur_recette, 
//                 utilisateur.nom_utilisateur AS nom_auteur, utilisateur.image_utilisateur AS image_auteur
//             FROM recette
//             INNER JOIN utilisateur ON recette.auteur_recette = utilisateur.id_utilisateur
//             WHERE recette.id_recette = :id_recette");
            
//             $req->bindParam(':id_recette', $id_recette, \PDO::PARAM_INT);
//             $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Recette::class);
//             $req->execute();
    
//             return $req->fetch();
//         } catch (\Exception $e) {
//             die('Error : ' . $e->getMessage());
//         }
//     }
// }


