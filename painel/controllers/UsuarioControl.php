<?php 

	/**************************************
	* CONTROLLER USUARIO
	**************************************/

	class UsuarioControl extends Controller{

		private $usuarioModel;
		private $moduloModel;

		public $caminhoImagensFotoPerfil;

		public function __construct($acesso = "cms"){

			// SETANDO O MÓDULO
			$this->setModulo('usuarios');

			$permission = new Permissions();
			$this->setPaginasPermitidas($permission);

			if($this->verifyPermissionPage() || $acesso == "api" || $acesso == "site"){

				// CARREGANDO A MODEL PRINCIPAL
				$this->usuarioModel 			= new UsuarioModel();
				$this->limite                   = 10;
				$this->caminhoImagensFotoPerfil = "usuarios_fotoPerfil";
			}else{

				errorPage(ERROR_PERMISSION_PAGE);
				exit;
			}
		}

		//CARREGA A VIEW PRINCIPAL DO MODULO
		public function index($pg = 1){

			$dados['pg']       = $pg;
			$dados['condicao'] = "";
			$dados['url']      = URL.'usuarios/index/';
			$dados['limite']   = $this->limite;
			$dados['usuarios'] = $this->listUsuarios($pg);
			$this->loadView('lista.php',$dados);
		}

		// CARREGA QUAL MÉTODO IRÁ RECEBER A REQUISIÇÃO AJAX
		public function loadMethod($acao, $id){

			if($acao != null){

				switch($acao):

					case 'delete':
						$idUsuario = isset($_GET['idUsuario']) ? $_GET['idUsuario'] : '';
						$this->delete($id,$idUsuario);
					break;

					case 'verificaEmail':

						// VALIDAÇÃO DE E-MAIL JÁ EXISTENTE NO BANCO (USUÁRIOS)
						$usuarioEmail     = isset($_POST['emailUsuario'])     ? $_POST['emailUsuario'] : null;
						$usuarioEmailEdit = isset($_POST['emailUsuarioEdit']) ? $_POST['emailUsuarioEdit'] : null;
						$usuarioEmailRef  = isset($_POST['emailUsuarioRef'])  ? $_POST['emailUsuarioRef'] : null;

						$resultado = $this->verificaEmail($usuarioEmail, $usuarioEmailEdit, $usuarioEmailRef);
						echo(json_encode($resultado));

					break;

				endswitch;
			}
		}

		//TRATA OS DADOS PARA SEREM INSERIDOS NO BANCO
		public function cadastrar(){
			
			$resultado['title']  = 'Cadastrar'; 
			$resultado['action'] = 'cadastrar';
			$resultado['legend'] = 'Novo';
			$resultado['name']   = 'novoUsuario';
			$resultado['resultado'] = false;

			if(isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "usuario"){

				$dados  = $this->validarCampos(INSERT);

				$insert = $this->usuarioModel->insert($dados,1);

				if($insert){
					$resultado['resultado'] = true;
				}else{
					$resultado['resultado'] = false;
				}

				$resultado['mensagem']  = $insert;
				$this->loadView('formulario.php',$resultado);
			}else{

				$this->loadView('formulario.php',$resultado);
			}
		}

		//TRATA OS DADOS PARA SEREM EDITADOS E ATUALIZADOS NO BANCO
		public function atualizar($id){

			if($id != null AND is_numeric($id)){

				if (isset($_REQUEST['modulo']) && $_REQUEST['modulo'] == "usuario") {
					
					$dados  = $this->validarCampos(UPDATE);
					$edicao = $this->usuarioModel->update($dados,$id);

					$resultado['resultado'] =  false;

					if(isset($edicao['success'])){

						$resultado['mensagem']  = $edicao;
						$resultado['resultado'] =  true;
					}else{

						$resultado['mensagem']  = $edicao;
					}

					$this->editar($id,$resultado);
				}else{

					errorPage(ERROR_MODULO_INCORRECT);
				}
				
			}else{

				errorPage(ERROR_ID_NOT_FOUND);
			}
		}

		//RECEBE UM DADO ESPECÍFICO PELO ID
		public function editar($id,$param = null){

			if($id != null AND is_numeric($id)){

				$usuario = $this->usuarioModel->getRow('u.id as usuarioId, l.id as loginId, nivelId, nome, fotoPerfil, sexo, dataNascimento, telefone, celular, cpf, email, status','WHERE u.id ='.$id);
				
				if(!isset($usuario['error'])){

					$resultado['usuario'] = $usuario['success'];
				}else{

					$resultado['usuario'] = "error";
				}
			
			}else{

				$resultado['usuario'] = "error";
			}

			if($resultado['usuario'] != "error"){
			
				$resultado['title']  = 'Editar'; 
				$resultado['action'] = 'atualizar/'.$id;
				$resultado['legend'] = 'Editar';
				$resultado['name']   = 'editarUsuario';
				
				$resultado['resultado']  = false;
				if($param != null){

					$resultado['resultado'] = true;
					$resultado['mensagem']  = $param['mensagem'];
					$resultado['id']        = $id;
				}

				$this->loadView('formulario.php',$resultado);
			}else{

				errorPage(ERROR_ID_NOT_FOUND);
			}
			
		}

		//RECEBE UMA LISTA COM TODOS OS REGISTROS 
		public function listUsuarios($pg=null,$busca=false){

			if($busca != false){

				$listar  = $this->usuarioModel->getList($pg);
			}else{

				$inicio  = ($pg * $this->limite) - $this->limite;
				$busca  = " ORDER BY u.nome ASC LIMIT $inicio, $this->limite ";
				$listar = $this->usuarioModel->getList($busca);
			}

			// MONTANDO LAYOUT TABELA

			// SETANDO O CABEÇALHO
			$cabecalhoTitulos = array('Nome', 'E-mail', 'Telefone', 'Status', 'Ações');
			$this->tabela->setCabecalho($cabecalhoTitulos);
			
			// VERIFICANDO SE HOUVE RETORNO DOS DADOS
			if(!isset($listar['error'])){

				// LISTANDO OS ADMINSTRADORES E MONTANDO AS LINHAS NA TABELA
				foreach($listar as $usuario){

					$dados = array(
									$usuario->getNome(), 
									$usuario->getLogin()->getEmail(), 
									$usuario->getTelefone(),
									showStatus($usuario->getLogin()->getStatus()), 
									"<a href=".URL."usuarios/editar/".$usuario->getId().">Editar</a>&nbsp;|
										<a data-id='".$usuario->getLogin()->getId()."' data-id-client='".$usuario->getId()."' class='excluir' href='#'>Excluir</a>"
									);
					
					$this->tabela->add_linha($dados);				
				}

			}else{
				// RESPOSTA QUANDO NÃO HOUVER RETORNO NA LISTAGEM
				$dados = array($listar['error']);
				$this->tabela->add_linha($dados);
			}
			
			// GERANDO O TEMPLATE DA TABELA COM AS INFORMAÇÕES
			$listar =  $this->tabela->generate();			

			return $listar;
		}

		//DELETA UM REGISTRO ESPECÍFICO PELO ID
		public function delete($id,$idUsuario=null){

			$resultado['resultado'] = true;
			if($id != null){

				$administradorModel = new AdministradorModel();
				$delete = $administradorModel->delete($id);
				if(!isset($delete['error'])){

					if($idUsuario != null){

						$deleteUsuario = $this->usuarioModel->delete($idUsuario);
					}

					$resultado['mensagem'] = $delete['success'];	
				}else{

					$resultado['resultado'] = false;
					$resultado['mensagem']  = $delete['error'];
				}
			}else{

				$resultado['resultado'] = false;
				$resultado['mensagem']  = 'Erro ao remover.';
			}

			echo json_encode($resultado);
			
		}

		// TRATAMENTO DOS DADOS ANTES DO ARMAZENAMENTO
		private function validarCampos($acao){

			$dados = array();

			// VERIFICAÇÃO DO ENVIO DE IMAGENS ATRAVÉS DE CADASTROS
			if(!empty($_FILES['usuariosFotoPerfil']['name'])){

				$imagemFotoPerfil = $this->usuarioModel->imagemUpload($_FILES['usuariosFotoPerfil'],$this->caminhoImagensFotoPerfil);
			}else{

				$imagemFotoPerfil = "";
			}

			$dados = array(
				'usuario' => array(
							'nivelId'        => $_POST['nivelUsuario'],
							'nome'           => $_POST['nomeCompletoUsuario'],
							'fotoPerfil'     => $imagemFotoPerfil,
							'sexo'           => isset($_POST['sexoUsuario']) ? $_POST['sexoUsuario'] : " ",
							'dataNascimento' => $_POST['dataNascimentoUsuario'],
							'telefone'       => $_POST['telefoneUsuario'],
							'celular'        => $_POST['celularUsuario'],
							'cpf'            => $_POST['cpfUsuario'],
				)
			);

			$dados['login']['email'] = isset($_POST['emailUsuario']) ? $_POST['emailUsuario'] : $_POST['emailUsuarioEdit'];

			if(!empty($_POST['senhaUsuario'])){

				$dados['login']['senha'] =  md5($_POST['senhaUsuario']);
			}

			$dados['login']['status']    = $_POST['acessoUsuario'];

			// CASO EXISTA ALGUMA VALIDAÇÃO ESPECÍFICA EM UMA AÇÃO
			switch($acao){

				case 1:
					// VALIDAÇÕES ESPECÍFICAS NA INSERÇÃO
				break;

				case 2:
					// VALIDAÇÕES ESPECÍFICAS NA ATUALIZAÇÃO
					$dados['login']['id'] = $_POST['idLogin'];
				break;

				default:
					// AÇÃO INDEFINIDA OU INVÁLIDA
					die('Ação indefinida');
				break;

			}

			return $dados;
		}

		public function verificaEmail($emailUsuario, $emailUsuarioEdit, $emailUsuarioRef){

			if(!empty($emailUsuario)){

				$usuario = $this->usuarioModel->getRow("u.id as idUsuario, l.id as idLogin, l.email","WHERE l.email ='".$emailUsuario."' ");

				if(!isset($usuario['error'])){

					$resultado = false;
				}else{

					$resultado = true;
				}
			}elseif($emailUsuarioEdit != $emailUsuarioRef){

				$usuario = $this->usuarioModel->getRow("u.id as usuarioId, l.id as loginId, l.email","WHERE l.email ='".$emailUsuarioEdit."' ");

				if(!isset($usuario['error'])){

					$resultado = false;
				}else{

					$resultado = true;
				}

			}else{

				$resultado = true;
			}

			return $resultado;
		}

		public function detalharUsuario($usuarioId){

			$resultado = $this->usuarioModel->getRow('u.id as usuarioId, l.id as loginId, l.email, l.status, nivelId, nome, fotoPerfil, sexo, dataNascimento, telefone, celular, cpf',
														'WHERE u.id ='.$usuarioId);

			return $resultado;
		}

		public function cadastrarUsuarioApi($usuarioNome,$usuarioEmail,$usuarioSenha,$usuarioUid){

			$dados = array(
				'usuario' => array(
							'nome'           => $usuarioNome,
							'fotoPerfil'     => "",
							'nivelId'        => 2,
							'sexo'           => "",
							'dataNascimento' => "",
							'telefone'       => "",
							'celular'        => "",
							'cpf'            => "",
				),
				'login' => array(
							'email'  => $usuarioEmail,
							'senha'  => $usuarioSenha,
							'status' => 1
				)
			);

			$insert = $this->usuarioModel->insert($dados,1);

			if(isset($insert['success'])){

				$resultado['success'] = $insert['success'];
			}else{

				$resultado = $insert;
			}

			return $resultado;
		}

		public function buscar(){

			// NOMES DAS COLUNAS A SEREM PESQUISADAS
			$this->colunas   = array("u.nome","");
			$this->ordenacao = "ORDER BY u.nome ASC";
			$pesquisa        = parent::buscar();

			// DADOS A SEREM RETORNADOS A PÁGINA
			$dados['pg']       = $pesquisa['indicePaginacao'];
			$dados['condicao'] = $pesquisa['condicaoPaginacao'];
			$dados['limite']   = $this->limite;
			$dados['url']      = URL."usuarios/buscar/".$pesquisa['paginaAtual']."/";
			$dados['usuarios'] = $this->listUsuarios($pesquisa['busca'],true);
			$this->loadView('lista.php',$dados);
		}
	}
?>