<?php
namespace App\Controller;
use App\Utils\Messagerie;
use App\vue\Template;
class HomeController{
    public function getHome(){
        $error = "";
        Template::render('navbar.php','footer.php', 'vueHome.php','Accueil', 
        $error,['script.js'],['styleCss.css']);
    }
    public function get404(){
        $error = "";
        Template::render('navbar.php','footer.php','vueError.php','Error 404',  
        $error,['script.js'],['styleCss.css']);
    }
    public function get401(){
        $error = "";
        Template::render('navbar.php','footer.php','vueNoRight.php','Error 401', 
        $error,['script.js'],['styleCss.css']);
    }
    public function testMail(){
        Messagerie::sendEmail('devnum@laposte.net','exemple de mail', 'test d\'envoi depuis recette');
    }
}
?>