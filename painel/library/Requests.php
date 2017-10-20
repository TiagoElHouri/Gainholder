<?php

session_start();

/**  RECEBE UMA REQUISIÇÃO VIA GET/POST E REALIZA O TRATAMENTO PARA O MÉTODO CORRETO */
require_once ('../config/Config.php');
require_once ('../helpers/Helpers.php');
require_once ('Autoload.php');

require('../library/xml2array.php');
require('../library/cURLFrete.php');
require('../library/phpQuery-onefile.php');

if(isset($_REQUEST['modulo']) && !empty($_REQUEST['modulo'])){

	$controller = $_REQUEST['modulo'];
	$acao       = isset($_REQUEST['acao']) ? $_REQUEST['acao'] : null; 
	$id         = isset($_GET['id'])   ? $_GET['id'] : null;
	
	switch ($controller){

		case 'administradores':

			$administradorControl = new AdministradorControl();
			$administradorControl->loadMethod($acao,$id);

		break;	

		case 'usuarios':

			$usuarioControl = new UsuarioControl();
			$usuarioControl->loadMethod($acao,$id);

		break;

		case 'exemplos':

			$exemploControl = new ExemploControl();
			$exemploControl->loadMethod($acao,$id);

		break;

		case 'correios':

			if(isset($_GET['cep']) && !empty($_GET['cep'])){

				$consultaCEP = array();

				// CORREIO
				$correio = new Correio($_GET['cep']);
				$cep     = $correio->ConsultarCep();

				if(isset($cep['Erro'])){

					$result = $cep;
				}else{

					$consultaCEP['estado']	   = $cep['uf'];
					$consultaCEP['cidade']	   = $cep['cidade'];
					$consultaCEP['bairro']	   = $cep['bairro'];
					$consultaCEP['logradouro'] = $cep['logradouro'];
					$result = $consultaCEP;
				}
			}

			print_r(json_encode($result));
		break;
	}
}