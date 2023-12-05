<?php
namespace App\Controller;
use App\Model\Utilisateur;
use App\Model\Recette;
use App\Model\Commentaire;
use App\vue\Template;
use App\Utils\Utilitaire;
class CommentaireController extends Commentaire{
    public function addCommentaire(){
        $error = "";
        //test si le paramètre $_GET['id_recette'] si il existe
        if(isset($_GET['id_recette'])){
            //test si le paramètre $_GET['id_recette'] si il est différent de vide
            if(!empty($_GET['id_recette'])){
                $recette = new recette();
                $recette->setId($_GET['id_recette']);
                //test si la recette existe
                if($recette->findOneBy()){
                    //test si le formulaire est submit
                    if(isset($_POST['submit'])){
                        //test si le formulaire est rempli
                        if(!empty($_POST['commentaire_commenter'])){
                            $date = new \DateTimeImmutable();
                            //setter la date
                            $this->setDate($date->format('Y-m-d'));
                            $this->setCommentaire(Utilitaire::cleanInput($_POST['commentaire_commenter']));
                            $this->setStatut(false);
                            $this->getAuteur()->setId(Utilitaire::cleanInput($_SESSION['id']));
                            $this->getRecette()->setIdRecette(Utilitaire::cleanInput($_GET['id_recette']));
                            //ajout du commentaire
                            $this->add();
                            $error = "Le commentaire à été ajouté";
                        }
                        //test si les champs ne sont pas remplis
                        else{
                            $error = "Veuillez remplir tous les champs du formulaire";
                        }
                    }
                }
                //test la recette n'existe pas
                else{
                    header('location: ./recettefilter');
                }
            }
            //test si le paramètre $_GET['id_recette] est vide
            else{
                header('location: ./recettefilter');
            }
        }
        //test si le paramètre $_GET['id_recette] n'existe pas
        else{
            header('location: ./recettefilter');
        }
        Template::render(
            'navbar.php',
            'footer.php',
            'vueAddCommentary.php',
            'Recette',
            $error,
            ['script.js'],
            ['styleCss.css'],
        );
    }

    public function allCommentaire(){
        $error = "";
        $commentaires = [];
        if(isset($_GET['id_recette'])){
            if(!empty($_GET['id_recette'])){
                $this->getRecette()->setId(Utilitaire::cleanInput($_GET['id_recette']));
                $commentaires = $this->findBy();
                if(empty($commentaires)){
                    $error = "il n'y a pas de commentaire";
                    header("Refresh:2; url=./recettefilter");
                }
            }else{
                header('location: ./recettefilter');
            }
        }else{
            header('location: ./recettefilter');
        }
        Template::render(
            'navbar.php',
            'footer.php',
            'vueAllCommentary.php',
            'Recette',
            $error,
            ['script.js'],
            ['styleCss.css'],
        );
    }
}