<?php
    //!import du fichier de configuration
    include './env.php';
    //!import de l'autoloader des classes
    require_once './autoload.php';
    require_once './vendor/autoload.php';
    use App\Controller\UtilisateurController;
    use App\Controller\RoleController;
    use App\Controller\HomeController;
    use App\Controller\RecetteController;
    use App\Controller\CommentaireController;
    use App\Controller\IngredientController;
    $userController = new UtilisateurController();  
    $roleController = new RoleController();
    $homeController = new HomeController();   
    $recetteController = new RecetteController();
    $commentaireController = new CommentaireController();  
    $ingredientController = new IngredientController();
    //!utilisation de session_start(pour gérer la connexion au serveur)
    session_start();
    //!Analyse de l'URL avec parse_url() et retourne ses composants
    $url = parse_url($_SERVER['REQUEST_URI']);
    //!test si l'url posséde une route sinon on renvoi à la racine
    $path = isset($url['path']) ? $url['path'] : '/';
    //!version connecté
    if(isset($_SESSION['connected'])){
        //routeur
        switch ($path) {
            case '/dbprojet':
                $homeController->getHome();
                break;
            case '/dbprojet/roleadd':
                $roleController->addRole();
                break;
            case '/dbprojet/userdeconnexion':
                $userController->deconnexionUser();
                break;
            case '/dbprojet/recetteadd':
                $recetteController->addRecette();
                break;
                case '/dbprojet/ingredientadd':
                    $ingredientController->addIngredient();
                    break;
            case '/dbprojet/recetteall':
                $recetteController->getAllRecette();
                break;
                // case '/dbprojet/recetteone':
                //     $recetteController->getOneRecette($id_recette);
                //     break;
            case '/dbprojet/emailtest':
                $homeController->testMail();
                break;
            case '/dbprojet/commentaireadd':
                $commentaireController->addCommentaire();
                break;
            case '/dbprojet/commentaireall':
                $commentaireController->allCommentaire();
                break;
            default:
                $homeController->get404();
                break;
        }
    }
    //!Version deconnecté
    else{
        switch ($path) {
            case '/dbprojet/':
                $homeController->getHome();
                break;
            case '/dbprojet/userconnexion':
                $userController->connexionUser();
                break;
            case '/dbprojet/useradd':
                $userController->addUser();
                break;
            case '/dbprojet/recetteall':
                $recetteController->getAllRecette();
                break;
            case '/dbprojet/emailtest':
                $homeController->testMail();
                break;
            case '/dbprojet/useractivate':
                $userController->activateUser();
                break;
            case '/dbprojet/commentaireall':
                $commentaireController->allCommentaire();
                break;
            case '/dbprojet/commentaireadd':
            // case '/dbprojet/recetteupdate':
                $homeController->get401();
                break;
            default:
                $homeController->get404();
                break;
        }
    }
?>
