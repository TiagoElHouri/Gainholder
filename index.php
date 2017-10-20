<?php


session_start();

include_once('painel/config/Config.php');
include_once('painel/library/Autoload.php');
include_once('painel/helpers/Helpers.php');
include_once('api/interfaceApi.php');

// URL PROTOCOL
$protocolo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

// URL
define('URL_SITE', $protocolo . '://' . $_SERVER['HTTP_HOST'] . SITE_PATH);


if(REDIRECT_PAINEL){
    header('Location:'.URL_SITE.'/painel/index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
   
    <head>
    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gainholder | </title>

        <!-- CSS -->
        
        <!-- Bootstrap -->
        <link href="<?php echo URL_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="<?php echo URL_SITE; ?>/assets/css/font-awesome.min.css" rel="stylesheet">

        <!-- NProgress -->
        <link href="<?php echo URL_SITE; ?>/assets/css/nprogress.css" rel="stylesheet">

        <!-- iCheck -->
        <link href="<?php echo URL_SITE; ?>/assets/css/green.css" rel="stylesheet">
        
        <!-- bootstrap-progressbar -->
        <link href="<?php echo URL_SITE; ?>/assets/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

        <!-- JQVMap -->
        <link href="<?php echo URL_SITE; ?>/assets/jqvmap.min.css" rel="stylesheet"/>

        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo URL_SITE; ?>/assets/css/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo URL_SITE; ?>/assets/css/custom.css" rel="stylesheet">

        <!-- JS -->
        <script>var URL_SITE = '<?php echo URL_SITE; ?>';</script>
        <script>var URL      = '<?php echo URL; ?>';</script>
       
        <script type="text/javascript" src="<?php echo URL_SITE ?>/assets/js/plugins.js"></script>
        <?php
            if(isset($_GET['pag'])){

                // SE EXISITR JS PARA A PÁGINA
                $modulo = strstr($_GET['pag'], '/') ? substr($_GET['pag'],0,strpos($_GET['pag'], '/')) : $_GET['pag'];

                if (file_exists('assets/js/pagina.' . $modulo . '.js')) {

                    echo '<script type="text/javascript" src="' . URL_SITE . '/assets/js/pagina.' . $modulo . '.js"></script>';
                }
            }
        ?>
    </head>
    <body>

        <div class="geral">

            <div class="row" style="height: 100%;">

                <div class="col-md-12" style="height:100%;">

                    <div class="conteudo">

                        <!-- BOAS VINDAS -->
                        <div class="row">

                            <div class="col-md-12">
                                <?php

                                    // O TOPO SÓ NÃO SERÁ CARREGADO NA TELA QUE ATUALIZA A SENHA, FEITA PÓS UM PEDIDO DE REDEFINIÇÃO
                                    if(isset($_GET['pag'])){

                                        $explode = explode('/',$_GET['pag']);

                                        if(!in_array('novaSenha', $explode)){

                                            include('topo.php');
                                        }
                                    }else{

                                        include('topo.php');
                                    }

                                    // 
                                    if(isset($_GET['pag'])){
                                        $pagina = new Loader($_GET['pag']);
                                        $pagina->redirecionar();
                                    }else{

                                        include('home.php');
                                    }
                                ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>