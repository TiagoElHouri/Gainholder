<?php

    session_start();

    include_once('config/Config.php');
    include_once('library/Autoload.php');
    include_once('helpers/Helpers.php');

    // URL PROTOCOL
    $protocolo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

    // URL
    define('URL_SITE', $protocolo . '://' . $_SERVER['HTTP_HOST'] . SITE_PATH);

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
        <link href="<?php echo URL; ?>/assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="<?php echo URL; ?>/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- NProgress -->
        <link href="<?php echo URL; ?>/assets/css/nprogress.css" rel="stylesheet">

        <!-- iCheck -->
        <link href="<?php echo URL; ?>/assets/css/iCheck/skins/flat/green.css" rel="stylesheet">
        
        <!-- bootstrap-progressbar -->
        <link href="<?php echo URL; ?>/assets/css/bootstrap-progressbar-3.3.4.css" rel="stylesheet">

        <!-- JQVMap -->
        <link href="<?php echo URL; ?>/assets/js/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo URL; ?>/assets/css/daterangepicker.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="<?php echo URL; ?>/assets/css/custom.css" rel="stylesheet">

        <!-- Datatables -->
        <link href="<?php echo URL; ?>/assets/css/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URL; ?>/assets/css/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

        <!-- JS -->
         <script>
            var URL = '<?php echo URL; ?>';
        </script>

        <!-- jQuery -->
        <script src="<?php echo URL; ?>/assets/js/jquery.min.js"></script>
        
        <!-- Bootstrap -->
        <script src="<?php echo URL; ?>/assets/js/bootstrap.js"></script>
        
        <script type="text/javascript" src="<?php echo URL ?>/assets/js/plugins.js"></script>
        <?php
            if(isset($_GET['pag'])){

                // SE EXISITR JS PARA A PÁGINA
                $modulo = strstr($_GET['pag'], '/') ? substr($_GET['pag'],0,strpos($_GET['pag'], '/')) : $_GET['pag'];

                if (file_exists('assets/js/pagina.' . $modulo . '.js')) {

                    echo '<script type="text/javascript" src="' . URL. '/assets/js/pagina.' . $modulo . '.js"></script>';
                }
            }
        ?>
    </head>
    <?php if(isset($_SESSION['ADMIN'])):?>
        
    <body class="nav-md">
    
        <div class="container body">
    
            <div class="main_container">

                <?php include ('views/menu.php'); ?>
                <?php include ('views/topo.php'); ?>

                <!-- page content -->
                <div class="right_col" role="main">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php

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
    </body>

    <?php else: ?>

        <body class="login">
            <?php include('views/login.php'); ?>
        </body>

    <?php endif; ?>
    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo URL; ?>/assets/js/custom.min.js"></script>
    
    <!-- FastClick -->
    <script src="<?php echo URL; ?>/assets/js/fastclick.js"></script>
    
    <!-- NProgress -->
    <script src="<?php echo URL; ?>/assets/js/nprogress.js"></script>
    
    <!-- Chart.js -->
    <script src="<?php echo URL; ?>/assets/js/Chart.js/dist/Chart.min.js"></script>
    
    <!-- gauge.js -->
    <script src="<?php echo URL; ?>/assets/js/gauge.js"></script>
    
    <!-- bootstrap-progressbar -->
    <script src="<?php echo URL; ?>/assets/js/bootstrap-progressbar.js"></script>
    
    <!-- iCheck -->
    <script src="<?php echo URL; ?>/assets/js/iCheck/icheck.min.js"></script>
    
    <!-- Skycons -->
    <script src="<?php echo URL; ?>/assets/js/skycons.js"></script>
    
    <!-- Flot -->
    <script src="<?php echo URL; ?>/assets/js/Flot/jquery.flot.js"></script>
    <script src="<?php echo URL; ?>/assets/js/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo URL; ?>/assets/js/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo URL; ?>/assets/js/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo URL; ?>/assets/js/Flot/jquery.flot.resize.js"></script>
    
    <!-- Flot plugins -->
    <script src="<?php echo URL; ?>/assets/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo URL; ?>/assets/js/jquery.flot.spline.js"></script>
    <script src="<?php echo URL; ?>/assets/js/curvedLines.js"></script>
    
    <!-- DateJS -->
    <script src="<?php echo URL; ?>/assets/js/DateJS/build/date.js"></script>
    
    <!-- JQVMap -->
    <script src="<?php echo URL; ?>/assets/js/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo URL; ?>/assets/js/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo URL; ?>/assets/js/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo URL; ?>/assets/js/moment.min.js"></script>
    <script src="<?php echo URL; ?>/assets/js/daterangepicker.js"></script>
    <script src="<?php echo URL; ?>/assets/js/validator.js"></script>

    <!-- Datatables -->
    <script src="<?php echo URL; ?>/assets/js/jquery.dataTables.js"></script>
    <script src="<?php echo URL; ?>/assets/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo URL; ?>/assets/js/dataTables.responsive.js"></script>
    <script src="<?php echo URL; ?>/assets/js/responsive.bootstrap.js"></script>
</html>