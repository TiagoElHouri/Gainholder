<?php

	class ExemploSiteControl extends Controller{

		private $moduloModel;

		public function __construct(){

			// SETANDO O MÓDULO
			$this->setModulo('exemplos');
		}

		//CARREGA A VIEW PRINCIPAL DO MÓDULO EXEMPLO
		public function index(){

			$dados['condicao'] = "";
			$dados['url']      = URL.'exemplos/index/';

			$api = new Api;

			// CARREGAMENTO DE DADOS PARA A PAGINA PRINCIPAL DO EXEMPLO
			$exemplo 		  = $api->detalharExemplo($exemploId);
			$dados['exemplo'] = $exemplo;

			$this->loadView('principal.php',$dados);
		}

		// FUNCIONALIDADES ESPECÍFICAS , ÁLEM DA PÁGINA PRINCIPAL DO EXEMPLO
		public function metodo(){

			$this->loadView('paginaExemplo.php',$dados);
		}
	}
?>