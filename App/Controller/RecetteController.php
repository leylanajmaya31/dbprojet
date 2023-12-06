<?php
namespace App\Controller;

use App\vue\Template;
use App\Model\Utilisateur;
use App\Utils\Utilitaire;
use App\Model\Recette;
use App\Model\Ingredient;

class RecetteController extends Recette {
    public function addRecette() {
        $error = "";
        $user = new Utilisateur();

        // Nettoyer l'ID de l'utilisateur provenant de la session
        $userId = Utilitaire::cleanInput($_SESSION['id']);
        $user->setId($userId);
        $users = $user->findAll();

        if(isset($_POST['submit'])) {
            if(
                !empty($_POST['nom_recette']) &&
                !empty($_POST['date_recette']) &&
                !empty($_POST['niveau_recette']) &&
                !empty($_POST['description_recette']) &&
                !empty($_POST['portion_recette']) &&
                !empty($_POST['unite_recette']) &&
                !empty($_POST['temps_recette']) &&
                !empty($_FILES['image_recette']['name']) && 
                !empty($_POST['ingredients'])
            ) {
                $this->setNom(Utilitaire::cleanInput($_POST['nom_recette']));
                $this->setDate(Utilitaire::cleanInput($_POST['date_recette']));
                $this->setNiveau(Utilitaire::cleanInput($_POST['niveau_recette']));
                $this->setDescription(Utilitaire::cleanInput($_POST['description_recette']));
                $this->setPortion(Utilitaire::cleanInput($_POST['portion_recette']));
                $this->setUnite(Utilitaire::cleanInput($_POST['unite_recette']));
                $this->setTemps(Utilitaire::cleanInput($_POST['temps_recette']));
                $this->getAuteur()->setId(Utilitaire::cleanInput($_SESSION['id']));
                // Nettoyer le nom du fichier image
                $imageName = Utilitaire::cleanInput($_FILES['image_recette']['name']);
                $uploadDir = './Public/asset/images/'; // Chemin vers le répertoire de destination
                $uploadFile = $uploadDir.basename($imageName);

                if(move_uploaded_file($_FILES['image_recette']['tmp_name'], $uploadFile)) {
                    // Le fichier a été téléchargé avec succès
                    $this->setImage($imageName);

                    // Vérifier si la recette existe déjà
                    $recette = $this->findOneBy();
                    if($recette) {
                        $error = "La recette existe déjà";
                    } else {
                        // Récupération de l'ID de la recette nouvellement ajoutée
                        $this->add();
                        $recette = $this->getIdRecette();
                        // Ajout des ingrédients
                        
                        // Récupération des ingrédients depuis $_POST
                        foreach($_POST['ingredients'] as $ingredientJson) {
                            $ingredientArray = json_decode($ingredientJson, true);
                            $ingredient = new Ingredient();
                            $ingredient->setNom($ingredientArray['name']);
                            $ingredient->setQuantite($ingredientArray['quantity']);
                            $ingredient->setUnite($ingredientArray['unit']);
                            $ingredient->addIngredient();
                            $ingredient->addIngredientToRecette($this->getIdRecette());
                        }

                        $error = "La recette et les ingrédients ont bien été ajoutés en base de données.";
                    }
                } else {
                    $error = "Erreur lors du téléchargement de l'image.";
                }
            } else {
                $error = "Veuillez remplir tous les champs du formulaire";
            }
        }
        Template::render(
            'navbar.php',
            'footer.php',
            'vueAddRecette.php',
            'Recette',
            $error,
            ['script.js'],
            ['styleCss.css'],
            $users
        );
    }

    public function getAllRecette() {
        $error = "";
        $recettes = $this->findAll();
        if(empty($recettes)) {
            $error = "Il n'y a pas de recettes à afficher";
        }
        Template::render(
            'navbar.php',
            'footer.php',
            'vueAllRecette.php',
            'Recette',
            $error,
            ['script.js'],
            ['styleCss.css'],
            $recettes
        );
    }
}

//     public function getRecette()
//     {
//         $error = "";
//         $recette = $this->find();
//         if (empty($recette)) {
//             $error = "Il n'y a pas de recettes à afficher";
//         }
//         Template::render(
//             'navbar.php',
//             'footer.php',
//             'vueOneRecette.php',
//             'Une Recette',
//             ['script.js', 'main.js'],
//             ['style.css', 'main.css'],
//             $error,
//             $recette
//         );
//     }
// }

// public function getOneRecette() {
//     $recette = $this->find();

//     if (!$recette) {
//         $error = "Il n'y a pas de recettes à afficher";
//     }

//     Template::render(
//         'navbar.php',
//         'footer.php',
//         'vueOneRecette.php',
//         'Détails de la Recette',
//         ['script.js', 'main.js'],
//         ['style.css', 'main.css'],
//         $error,
//         $recette
//     );
// }

// public function getOneRecette($id_recette) {
//     $recette = $this->find($id_recette);

//     if (!$recette) {
//         $error = "La recette n'existe pas";
//     }

//     Template::render(
//         'navbar.php',
//         'footer.php',
//         'vueOneRecette.php',
//         'Détails de la Recette',
//         ['script.js', 'main.js'],
//         ['style.css', 'main.css'],
//         $error,
//         $recette
//     );
// }






// public function filterRecette(){
//     $error = "";
//     $recettes = $this->filterAll(5);
//     if($recettes){
//         if(isset($_POST['submit'])){
//             if(!empty($_POST['filter'])){
//                 $recettes = $this->filterAll(Utilitaire::cleanInput($_POST['filter']));
//             }
//         }
//     }
//     else{
//         $error = "La liste des recettes est vide ";
//     }

//     Template::render('navbar.php','footer.php','vueFilterAllRecettes.php','Filtrer recettes', 
//     ['script.js', 'main.js'], ['style.css', 'main.css'],$error, $recettes);
// }
