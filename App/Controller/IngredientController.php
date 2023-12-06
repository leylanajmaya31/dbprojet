<?php
namespace App\Controller;
use App\Model\Ingredient;
use App\vue\Template;
use App\Model\Utilisateur;
use App\Utils\Utilitaire;

class IngredientController extends Ingredient{
    public function add(){
        $error = "";
        $user = new Utilisateur();
    
        // Nettoyer l'ID de l'utilisateur provenant de la session
        $userId = Utilitaire::cleanInput($_SESSION['id']);
        $user->setId($userId);
        $users = $user->findAll();
        if (isset($_POST['submit'])) {
            if ( !empty($_POST['ingredients'])) {
                
                $this->setNom(Utilitaire::cleanInput($_POST['nom_ingredient']));
                $this->setQuantite(Utilitaire::cleanInput($_POST['quantite_ingredient']));
                $this->setUnite(Utilitaire::cleanInput($_POST['unite_ingredient']));
                if(!$this->findOneBy()){
                    $this->add();
                    $error = "Les ingredients ont été ajoutés en BDD";
                }else{
                    $error = "Les ingredients existent déja";
                }
            }
            else{
                $error = "Veuillez saisir le nom des ingredients";
            }
        }
        Template::render('navbar.php', 'footer.php','vueAddIngredient.php','Ingredient',   
        $error,['script.js'],['styleCss.css'], $users);
    }
}

