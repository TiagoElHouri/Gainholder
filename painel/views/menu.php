<?php 
    $permission = new Permissions();
    $paginas    = $permission->makeMenu();

    $modulosSelecionados  = array();
    $subPaginasPermitidas    = array();
    $contadorPaginas      = 0;
    $subPaginaCont        = 1;
    $paginasPai           = array();

    if(is_array($paginas) && !array_search(null, $paginas)){
        
        foreach($paginas as $pagina){

            if(!in_array($pagina[0]->getId(), $modulosSelecionados) && $pagina[0]->getIdPai() == '0'){
                array_push($modulosSelecionados, $pagina[0]->getId()); 
                array_push($paginasPai, $pagina[0]);
            }

            if(count($pagina) > 1){

                foreach($pagina as $subpagina){

                    if(in_array($subpagina->getIdPai(), $modulosSelecionados)){

                        $subPaginasPermitidas[$subpagina->getIdPai()][$subPaginaCont] = $subpagina;
                        $subPaginaCont++;
                    }
                   
                }
            }

           
        }
    }


?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo URL; ?>" class="site_title"><i class="fa fa-building"></i> <span>Gainholder</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo URL ?>/assets/img/user.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Bem Vindo,</span>
                <h2>Tiago El Houri</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section active">
                <h3>Geral</h3>
                <ul class="nav side-menu">

                    <?php 
                        // LISTA MENU E SUB-MENUS
                        $cont = 0;
                        $linkMenu = '#';

                        if(is_array($paginasPai) && !is_null($paginasPai)):

                            foreach($paginasPai as $pagina ):
                       
                                $ativo = ($cont == 0) ? 'class="active"' : '';

                                if(!empty($pagina->getUrl())){
                                    $linkMenu = URL.'/'.$pagina->getUrl(); 
                                }
                            ?>

                                <li <?php echo $ativo; ?>>
                                        <a href="<?php echo $linkMenu; ?>"><i class="fa <?php echo $pagina->getIcone(); ?>"></i> <?php echo $pagina->getNome(); ?>

                            <?php   if(isset($subPaginasPermitidas[$pagina->getId()])):  ?>

                                        <span class="fa fa-chevron-down"></span></a>
                                        
                                        <ul class="nav child_menu">
                               
                                <?php   foreach($subPaginasPermitidas[$pagina->getId()] as $subpagina):?>

                                               
                                            <li>
                                                <a href="<?php echo URL ?>/<?php echo $subpagina->getUrl(); ?>">
                                                    <?php echo $subpagina->getNome(); ?></a>
                                            </li>   
                                    
                                <?php   endforeach;  ?>
                                            </ul> 
                                        </li>
                                <?php else: ?>
                                        </a>
                                    </li>
                                <?php 

                                    endif;

                                $cont++;

                                $linkMenu = '#';    

                            endforeach;
                        endif;

                        
                    ?>

      <!--               <li class="active">
                        <a><i class="fa fa-lock"></i> Gerenciar Acessos <span class="fa fa-chevron-down">
                        </span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php //echo URL ?>/administradores">Administradores</a></li>
                            <li><a href="#">Colunistas</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-users"></i> Gerenciar Clientes</a></li>
                    <li><a><i class="fa fa-newspaper-o"></i> Gerenciar Notícias <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="#">Conteúdos</a></li>
                            <li><a href="#">Artigos</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-list"></i> Gerenciar Categorias</a></li>
                    <li><a><i class="fa fa-info"></i> Gerenciar Soluções</a></li>
                    <li><a><i class="fa fa-pencil"></i> Gerenciar Assinaturas</a></li>
                    <li><a><i class="fa fa-cog"></i> Gerenciar Configurações</a></li> -->
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /sidebar menu -->

                <?php
                    
                    // if ($paginas != null): 
            
                    //  foreach ($paginas as $pagina):
                     
                    //      if(is_object($pagina)):
                ?>

<!--                             <li><a href="<?php  //echo  URL . $pagina->getUrl(); ?>" title="<?php //echo $pagina->getNome(); ?>"><?php // echo $pagina->getNome(); ?></a></li> --> 
                <?php  

                    //     endif;
                      
                    //   endforeach;

                    // endif;  
                ?>


