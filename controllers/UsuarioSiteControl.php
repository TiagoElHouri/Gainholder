<?php

	class UsuarioSiteControl extends Controller{

		private $moduloModel;

		public function __construct(){

			// SETANDO O MÓDULO
			$this->setModulo('usuarios');
		}

		//CARREGA A VIEW PRINCIPAL DO MODULO USUÁRIOS
		public function index(){

			$dados['condicao'] = "";

			// CASO O USUÁRIO NÃO ESTEJA EM SESSÃO, A TELA LOGIN SERÁ CARREGADA AO ÍNVES DO PERFIL
			if(isset($_SESSION['USER'])){

				$api = new Api;

				$usuario = $api->detalharUsuario($_SESSION['USER']['ID']);

				$dados['usuario'] = $usuario;
				$this->loadView('perfil.php',$dados);
			}else{

				$this->loadView('login.php',$dados);
			}
		}

		// ENVIO DE E-MAIL PARA RECUPERAÇÃO DE SENHA
		public function cadastrar(){

			$resultado['title']     = 'Cadastrar';
			$resultado['action']    = 'cadastrar';
			$resultado['legend']    = 'Novo';
			$resultado['name']      = 'novoUsuario';
			$resultado['resultado'] = false;

			if(isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "usuario"){

				$api = new Api;

				$dados = "";

				$insert = $api->cadastrarUsuario($_POST['nomeUsuario'],$_POST['emailUsuario'],md5($_POST['senhaUsuario']),null);

				if($insert){

					$resultado['resultado'] = true;
 				}else{

					$resultado['resultado'] = false;
				}

				$resultado['mensagem'] = $insert;
				$this->loadView('cadastrar.php',$resultado);
			}else{

				$this->loadView('cadastrar.php',$resultado);
			}
		}

		// ENVIO DE E-MAIL PARA RECUPERAÇÃO DE SENHA
		public function esqueceuSenha(){

			$dados['condicao'] = "";
			$this->loadView('recuperar-senha.php',$dados);
		}

		// RENOVAÇÃO DE SENHA ATRAVÉS DE LINK ENVIADO VIA E-MAIL
		public function novaSenha(){

			$dados['condicao'] = "";
			$this->loadView('nova-senha.php',$dados);
		}
	}
?>