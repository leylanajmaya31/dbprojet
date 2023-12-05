<?php
namespace App\vue;
class Template{
    public static function render($navbar,$footer,$content,$title,$error, array $js,array $css,$tab=null){
        if(file_exists('./App/Vue/'.$content)){
            include './App/Vue/'.$navbar;
            include './App/Vue/'.$footer;
            include './App/Vue/'.$content;
            foreach($js as $value){
                echo '<script src="Public/asset/script/'.$value.'"></script>';
            }
            foreach($css as $value) {
                echo '<link rel="stylesheet" href="Public/asset/style/'.$value.'">';
            }
        }
        else{
            $navbar = "";
            $footer = "";
            $title = "Error 404";
            include './App/Vue/vueError.php';
        }
        include './App/Vue/vueTemplate.php';
    }
}
?>