<?php
namespace App\Controller;
use App\Model\Utilisateur;
use App\Utils\Utilitaire;
use App\vue\Template;
use App\Utils\Messagerie;
class UtilisateurController extends Utilisateur{
    public function addUser(){
        $error = "";
        //!tester si le formulaire est submit
        if(isset($_POST['submit'])){
            //!test si les champs sont remplis
            if(!empty($_POST['nom_utilisateur']) AND !empty($_POST['prenom_utilisateur']) 
            AND !empty($_POST['email_utilisateur']) AND !empty($_POST['mdp_utilisateur']) 
            AND !empty($_POST['repeat_mdp_utilisateur'])){
                //!Test si les mots de passe correspondent
                if($_POST['mdp_utilisateur']==$_POST['repeat_mdp_utilisateur']){
                    //!setter les valeurs à l'objet UtilisateurController
                    $this->setNomUtilisateur(Utilitaire::cleanInput($_POST['nom_utilisateur']));
                    $this->setPrenom(Utilitaire::cleanInput($_POST['prenom_utilisateur']));
                    $this->setEmail(Utilitaire::cleanInput($_POST['email_utilisateur']));
                    //!tester si le compte existe
                    if(!$this->findOneBy()){
                        if($_FILES['image_utilisateur']['tmp_name'] != ""){
                            $ext = Utilitaire::getFileExtension($_FILES['image_utilisateur']['name']);
                            if($ext=='png' OR $ext =='PNG' OR $ext = 'jpg' OR $ext =='JPG'OR $ext =='jpeg' OR $ext == 'JPEG' OR $ext=='bmp' OR $ext=='BMP'){
                                $this->setImage($_FILES['image_utilisateur']['name']);
                                move_uploaded_file($_FILES['image_utilisateur']['tmp_name'], './Public/asset/images/'.$_FILES['image_utilisateur']['name']);
                            }
                            else{
                                $error = 'format incorrect';
                                $this->setImage('test.png');
                            }
                        }
                        else{
                            $this->setImage('test.png');
                        }
                        $this->setStatut(false);
                        //!hashser le mot de passe
                        $this->setMdp(password_hash(Utilitaire::cleanInput($_POST['mdp_utilisateur']), PASSWORD_DEFAULT));
                        //!Créer les variables
                        $destinataire = $this->getEmail();
                        // dd($destinataire);
                        $objet = "Cliques plus bas pour faire fonctionner le compte";
                        $contenu = "<p>Cliques en dessous pour accéder au site 
                        </p><a href='http://localhost/projet/useractivate?mail=$destinataire'>Cliquez ici !</a>";
                        //!Ajouter le compte en BDD
                        $this->add();
                        //!Envoyer le mail de confirmation de compte
                        Messagerie::sendEmail($destinataire, $objet, $contenu);
                        $error = "Le compte a été ajouté en BDD";
                    }    
                    
                    else{
                        $error = "Le compte existe déja";
                    }
                }else{
                    $error = "Les mots de passe ne correspondent pas";
                }
            }else{
                $error = "Veuillez renseigner tous les champs du formulaire";
            }
        }
        Template::render('navbar.php','footer.php','vueAddUser.php','Inscription', 
        ['script.js'],['style.css'],$error);
    }
    public function connexionUser(){   
        $error ="";
        //!tester si le formulaire est submit
        if(isset($_POST['submit'])){
            //!tester si les champs sont remplis
            if(!empty($_POST['email_utilisateur']) AND !empty($_POST['mdp_utilisateur'])){
                //!tester si le compte existe (findOneBy du model)
                $this->setEmail(Utilitaire::cleanInput($_POST['email_utilisateur']));
                $user = $this->findOneBy();
                if($user){
                    //!tester si le mot de passe correspond (password_verify)
                    if(password_verify(Utilitaire::cleanInput($_POST['mdp_utilisateur']), $user->getMdp())){
                        $error = "Connecté";
                        $_SESSION['connected'] = true;
                        $_SESSION['id'] = $user->getId();
                        $_SESSION['nom'] = $user->getNomUtilisateur();
                        $_SESSION['prenom'] = $user->getPrenom();
                        $_SESSION['image'] = $user->getImage();
                        $error = 'vous êtes connecté';
                        header('Location: ./');
                    }else {
                        $error = "Les informations de connexion ne sont pas valides";
                    }
                }else{
                    $error = "Les informations de connexion ne sont pas valides";
                }
            }else{
                $error = "Veuillez renseigner tous les champs du formulaire";
            }
        }
        Template::render('navbar.php','footer.php','vueConnexionUser.php','Connexion', 
        ['script.js', 'main.js'], ['style.css', 'main.css'],$error);
    }
    public function deconnexionUser(){
        unset($_COOKIE['PHPSESSID']);
        session_destroy();
        header('Location: ./');
    }

    //!fonction pour activer le compte d'un utilisateur en lui envoyant un mail!
    public function activateUser(){
        $error = "";
        $url = "";
        //!tester si le paramètre existe
        if(isset($_GET['email_utilisateur'])){
            //!tester si le paramètre $_GET['mail'] est rempli
            if(!empty(($_GET['email_utilisateur']))){
                //!setter la valeur de $_GET['mail'] à l'attribut mail_utilisateur
                $this->setEmail(Utilitaire::cleanInput($_GET['email_utilisateur']));
                //!appeler la fonction findOneBy qui va retourner un compte (objet) 
                //!qui existe ou false
                if($this->findOneBy()){
                    $this->update();
                    $error = 'le compte a été activé';
                    $url = "./userconnexion";
                }
                //!Test le compte n'existe pas
                else{
                    $error = 'Aucun compte trouvé';
                    $url = "./useradd";
                }
            }
            //!tester si le paramètre $_GET['email'] est vide
            else{
                $error = 'le mail n\'est pas renseigné';
                $url = "./useradd";
            }
        }
        //!le paramètre $_GET['email'] n'existe pas
        else{
            $error = 'le paramètre n\'existe pas';
            $url = "./useradd";
        }
        //!appel de la vue (page html)
        Template::render('navbar.php','footer.php','vueActivateUser.php','Activation', 
        ['script.js', 'main.js'], ['style.css', 'main.css'],$error);
        //!redirection arès 2 secondes
        header("Refresh:2; url=$url");
    }
}

