<?php

    if (isset($_GET['pag'])) {

        $pagina = new Loader($_GET['pag']);

        if(!strstr($_GET['pag'], '/')){ 

            $controller = $pagina->getControllerPage();

            // CASO SEJA UTILIZADO O NOME ORIGINAL DO MÓDULO, SE FAZ NECESSÁRIO O TRATAMENTO
            // PARA INCLUIR O NOME DO CONTROLLER NA MESMA ESTRUTURA QUE É INSERIDO O CONTROLLER 
            // DE UMA PÁGINA COM NICKNAME
            if(!isset($controller['controller'])){

                $auxController            = $controller;
                $controller               = array();
                $controller['controller'] = $auxController;
            }

            $classe =  ucfirst($controller['controller'])."Control";

            if(class_exists($classe)){
                $objeto = new $classe();
                $loadView = $objeto->index();
            }else{
                errorPage(ERROR_CLASS_NOT_FOUND);
            }

        }else{

            $controller = $pagina->getControllerPage(true);
            $classe =  ucfirst($controller['controller'])."Control";

            if(class_exists($classe)){

                $objeto = new $classe();

                if(method_exists($objeto, $controller['acao'])){

                    if(!isset($controller['id'])){

                        $loadAction = $objeto->$controller['acao']();
                    }else{

                        if(isset($controller['pagina'])){

                            if(isset($controller['adicional'])){

                                $loadAction = $objeto->$controller['acao']($controller['id'], $controller['pagina'], $controller['adicional']);
                            }else{

                                $loadAction = $objeto->$controller['acao']($controller['id'], $controller['pagina']);
                            }
                        }else{

                            $loadAction = $objeto->$controller['acao']($controller['id']);
                        }
                    }
                }else{

                    errorPage(ERROR_METHOD_ACTION);
                }
            }else{

               errorPage(ERROR_CLASS_NOT_FOUND);
            }
        }
    }
?>