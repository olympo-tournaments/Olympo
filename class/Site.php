<?php
    class Site{
        public static function alert($alerta, $mensagem){
            if($alerta == "permitido") {
                echo '<div class="alert-box box-permitido"><i class="fas fa-check"></i> '.$mensagem.'</div>';
            } else if ($alerta == "aviso") {
                echo '<div class="alert-box box-aviso"><i class="fas fa-exclamation-triangle"></i> '.$mensagem.'</div>';
            } else {
                echo '<div class="alert-box box-erro"><i class="fas fa-times"></i> '.$mensagem.'</div>';
            }
        }
        public static function carregarPagina(){
            //.htaccess transforma a url em url amigavel
            if(isset($_GET['url'])) {
                //pega o URL
                $url = explode('/', $_GET['url']);//splita a URL
                if(file_exists('pages/'.$url[0].'.php')){
                    //o indice 0 é o nome do arquivo
                    include('pages/'.$url[0].'.php');
                } else {
                    //pagina nao exisite
                    //header('Location: '.INCLUDE_PATH);
                    include('pages/404.php');
                }
            } else {
                include('pages/home.php');
            }
        }
    }
?>