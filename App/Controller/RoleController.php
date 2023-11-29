<?php
namespace App\Controller;
use App\Model\Role;
use App\Utils\Utilitaire;
class RoleController extends Role{
    public function addRole(){
        $error = "";
        if(isset($_POST['submit'])){
            if(!empty($_POST['nom_role'])){
                $this->setNom(Utilitaire::cleanInput($_POST['nom_role']));
                if(!$this->findOneBy()){
                    $this->add();
                    $error = "Le role a été ajouté en BDD";
                }else{
                    $error = "Le role existe déja";
                }
            }
            else{
                $error = "Veuillez saisir le nom du role";
            }
        }
        include './App/Vue/vueAddRole.php';
    }
}