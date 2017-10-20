<?php  

/**************************************************************************
* VERIFICA O ACESSO AO SISTEMA E RETORNA AS PERMISSÕES DO USUÁRIO NO PAINEL
****************************************************************************/

class Permissions{

	private $login;
	private $tipo;

	public function __construct(Login $login = null){
		$this->login = $login;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function verifyLogin($area){

		if($this->login->getEmail() != null AND $this->login->getSenha() != null){

			$mysql = new Mysql();

			//CODIFICAÇÃO DA SENHA
			$senha = md5($this->login->getSenha());
			
			//SEPARAÇÃO DOS DADOS DE ACESSO EM E-MAIL
			$dadosEmail = array(
						'email'         => $this->login->getEmail(),
						'status'        =>1
			);

			//SEPARAÇÃO DOS DADOS DE ACESSO EM SENHA
			$dadosSenhaEmail = array(
						'email'         => $this->login->getEmail(),
						'senha'         => $senha,
						'status'        =>1
			);

			//VERIFICAÇÃO DA EXISTÊNCIA DE E-MAIL NO BANCO DE DADOS
			if($this->getTipo() == "administrador"){

				$sqlEmail = "SELECT * FROM login  WHERE email=:email AND status=:status";
			
			}else{

				$sqlEmail = "SELECT l.*, u.nome as nomeUsuario, u.nivelId as nivel, u.telefone FROM login l
			 			JOIN usuarios u ON (u.id = l.usuarioId)
						WHERE email=:email AND status=:status";
			}

			$verificaEmail = $mysql->getRow($sqlEmail, $dadosEmail);

			//VERIFICAÇÃO DA SENHA INFORMADA SE ESTÁ DE ACORDO COM A QUE CONSTA NO BANCO DE DADOS
			$sqlSenhaEmail = "SELECT * FROM login  
							WHERE email=:email AND senha = :senha AND status=:status";

			$verificaSenhaEmail = $mysql->getRow($sqlSenhaEmail, $dadosSenhaEmail);

			if($verificaEmail && $verificaSenhaEmail){

				if($this->getTipo() == "administrador"){

					// DELETA AS ENTRADAS DE ERROS EM CASO DE UM ACESSO VÁLIDO DO ADMINISTRADOR
					// $sqlDeleteErros = "DELETE le.* FROM login_erros le
					// INNER JOIN login ln
					// ON ln.email=le.email
					// WHERE (ln.email=:email)";

					// $campos   = array("email" => $verificaEmail->email);
					// $mysql->execute($sqlDeleteErros,$campos);
					$idLogin = $verificaEmail->id_login;

					$listagemModulos = $this->listarModulosPermitidos($idLogin);


					// INICIALIZAÇÃO DA SESSÃO DO USUÁRIO DO PAINEL
					$_SESSION['ADMIN']['ID']         = $verificaEmail->id_login;
					//$_SESSION['ADMIN']['NIVEL']      = $verificaEmail->nivel;
					//$_SESSION['ADMIN']['NAME']   	 = $verificaEmail->nomeUsuario;
					$_SESSION['ADMIN']['EMAIL']  	 = $verificaEmail->email;
					$_SESSION['ADMIN']['STATUS'] 	 = $verificaEmail->status;
					$_SESSION['ADMIN']['PERMISSOES'] = $listagemModulos;

					echo '<script>window.location="'.URL.'administradores"</script>';
				}else{

					// DELETA AS ENTRADAS DE ERROS EM CASO DE UM ACESSO VÁLIDO DO USUÁRIO
					$sqlDeleteErros = "DELETE le.* FROM login_erros le
					INNER JOIN login ln
					ON ln.email=le.email
					WHERE (ln.email=:email)";

					$campos         = array("email" => $verificaEmail->email);
					$mysql->execute($sqlDeleteErros,$campos);

					// INICIALIZAÇÃO DA SESSÃO DO USUÁRIO DO PAINEL
					$_SESSION['USER']['ID']         = $verificaEmail->usuarioId;
					$_SESSION['USER']['EMAIL']  	= $verificaEmail->email;
					$_SESSION['USER']['NAME']   	= $verificaEmail->nomeUsuario;
					$_SESSION['USER']['STATUS'] 	= $verificaEmail->status;
					$_SESSION['USER']['NIVEL']      = $verificaEmail->nivel;
					$_SESSION['USER']['PERMISSOES'] = $verificaEmail->permissoes;

					echo '<script>window.location="'.URL_SITE.'/perfil"</script>';
					// SESSÃO PARA OS PROJETOS QUE POSSUIREM UM ENDEREÇO NA WEB
				}

				$resultado['success'] = true;
 			}else{

 				if($verificaEmail){

					//VERIFICAÇÃO DA EXISTÊNCIA DE TRÊS ENTRADAS PARA DIRECIONAR À INSTRUÇÕES
					$sqlEmails = "SELECT * FROM login_erros WHERE email='".$this->login->getEmail()."' ";

					$verificaEmails = $mysql->getList($sqlEmails);

					if(count($verificaEmails) < 2){

	 					// CASO EXISTA O E-MAIL NO SISTEMA ELE SERÁ ARMAZENADO COMO UMA TENTATIVA FALHA
						$sqlInsert = "INSERT INTO login_erros (dataTentativa,email) VALUES(:dataTentativa,:email)";
						$campos    = array(
										   'dataTentativa' => date('Y-m-d'), 
							               'email'         => $dadosEmail['email']
										);

						$mysql->execute($sqlInsert,$campos);

						//VERIFICAÇÃO DA EXISTÊNCIA DE TRÊS ENTRADAS PARA ORIENTAR QUANTO ÀO NÚMERO DE TENTATIVAS
						$sqlTentativas = "SELECT * FROM login_erros WHERE email='".$this->login->getEmail()."' ";

						$verificaTentativas  = $mysql->getList($sqlTentativas);

						if(count($verificaTentativas) == 2){

							$tantativasRestantes = (3 - ((int) count($verificaTentativas)));
							$resultado['error']  = '<h3>Verifique com cuidado os dados!</h3></br>Suas tentativas estão acabando. Você só tem '.$tantativasRestantes.' tentativa(s)! Após exceder esse número, seu acesso só será liberado através da aprovação do administrador!';
						}else{

							$resultado['error']  = '<h3>Dados incorretos!</h3></br>Não foi possível realizar a autenticação. Por favor, confira seus dados!';
						}
					}else{

						$resultado['error'] = '<h3>Acesso bloqueado por excesso de tentativas</h3></br>Olá '.$verificaEmail->nomeUsuario.', seu acesso foi bloqueado pelo excesso de tentativas. Por favor, contate o administrador para liberação. Lembre-se de que esse recurso é para sua segurança.';

						$this->recuperarSenha($area);
					}
 				}else{

 					$resultado['error'] = '<h3>Aviso!</h3></br>Não foi possível realizar a autenticação. Por favor, confira seus dados!';
 				}
			}
		}else{

			$resultado['error'] = 'Campos em branco! Preencha os dois campos.';
		}

		return $resultado;
	}

	/**
	* RETORNA OS MÓDULOS QUE O ADMINISTRADOR LOGADO POSSUI PERMISSÃO
	* @return object ou null	
	*/
	public function makeMenu(){

		if(isset($_SESSION['ADMIN'])){

			$moduloModel = new ModuloModel();
			$modulos     = $moduloModel->getListPermissions($_SESSION['ADMIN']['PERMISSOES']);
		}else{

			$modulos = null;
		}

		return $modulos;
	}

	/**
	* LISTA OS MÓDULOS PERMITIDO PARA O ADMINISTRADOR
	* @return object ou null	
	*/
	public function listarModulosPermitidos($idLogin){
		$mysql = new Mysql();

		$sqlListarModulos = " SELECT p.*, m.id_pai FROM permissoes p
							INNER JOIN modulos m ON m.id_modulo = p.id_modulo
							INNER JOIN login l ON l.id_login = p.id_login
							WHERE p.id_login = '$idLogin'";

		$lista = $mysql->getList($sqlListarModulos);

		return $lista;
	}

	public function recuperarSenha($area){

		$mysql = new Mysql();

		$sqlDetalharLoginUsuario = "SELECT l.id, l.email, l.senha, u.nome FROM login l 
			 		                JOIN usuarios u ON (u.id = l.usuarioId) WHERE email=:email";

		$dados = array('email' => $this->login->getEmail());

		$verifica = $mysql->getRow($sqlDetalharLoginUsuario, $dados); 

		if($verifica){

			$loginClienteNome  = $verifica->nome;
			$loginClienteEmail = $verifica->email;
			$senhaBase64       = base64_encode($verifica->id . ',' . $verifica->senha);

			// ENVIA E-MAIL AO LOGIN DO CLIENTE
			$emailAssunto  = "Recuperação de senha de acesso";

			$emailConteudo = "<p> Olá $loginClienteNome,</p>";

			//VERIFICAÇÃO DA EXISTÊNCIA DE TRÊS ENTRADAS PARA DIRECIONAR À INSTRUÇÕES
			$sqlEmails = "SELECT * FROM login_erros WHERE email='".$this->login->getEmail()."' ";

			$verificaEmails = $mysql->getList($sqlEmails);

			if(count($verificaEmails) == 3){

				$emailConteudo  .= "<p>Devido a tentativas de login erradas, a alteração de senha foi solicitada.</p>";
			}else{

				$emailConteudo  .= "<p>Uma solicitação de alteração de senha foi solicitado para o seu usuário.</p>";
			}

			$emailConteudo  .= "<p>Para confirmar a solicitação clique no link abaixo:</p>";

			// VERIFICAÇÃO DA ÁREA RESPONSÁVEL PELA REQUISIÇÃO DE RENOVAÇÃO DE SENHA
			if($area == "site"){

				$emailConteudo  .= URL_SITE . '/perfil/novaSenha/' . $senhaBase64;
			}else{

				$emailConteudo  .= URL.'esqueceu-senha/' . $senhaBase64;
			}

			$emailConteudo  .= "<p>Atenciosamente,</p> <p>Palupa</p>";

			$email 		 = new Email();
			$enviarEmail = @$email->Enviar(EMAIL_REMETENTE, EMAIL_REMETENTE_NOME, $loginClienteEmail, $loginClienteNome, $emailAssunto, $emailConteudo);

			if($enviarEmail == 1){

				return array('success' => '<h3>Redefinição de senha</h3></br>Olá '.$loginClienteNome.', <br /> Recentemente você solicitou um link para redefinir sua senha e para concluir o processo acesse seu e-mail cadastrado.');
			}else{

				return array('error' => '<h3>Oops! E-mail não enviado</h3></br>Por favor, contate o administrador para corrigir este problema.');
			}
		}else{

			$resultado = array('error' => '<h3>Ops! Dados incorretos!</h3></br>Não foi possível realizar a autenticação. Por favor, confira seus dados!');
		}
		
		return $resultado;
	}

	public function renovarSenha($base64){

		$mysql = new Mysql();

		$base64 = explode(',', base64_decode($base64));

		$id	   = $base64[0];
		$senha = $base64[1];

		$novaSenha =  $this->login->getSenha();

		$sqlAutenticarUsuario = "SELECT id FROM login WHERE id=:id AND senha=:senha";
		$dados                = array('id' => $id, 'senha' => $senha);
		$autenticarUsuario    = $mysql->getRow($sqlAutenticarUsuario, $dados);

		if($autenticarUsuario){

			$sqlEditarUsuario 	= "UPDATE login SET senha = '$novaSenha' WHERE id = '$id'";
			$campos             = array("");
			$editarUsuario		= $mysql->execute($sqlEditarUsuario,$campos);

			$sqlDeleteErros = "DELETE le.* FROM login_erros le
								INNER JOIN login ln
								ON ln.email=le.email
								WHERE (ln.id=:id)";

			$campos         = array("id" => $id);
			$mysql->execute($sqlDeleteErros,$campos);

			if($editarUsuario){

				return array('success' => '<h3>Uhull! Sua senha foi redefinida com sucesso!</h3></br>Faça login com seus novos dados.');
			}else{

				return array('error' => 'Falha ao tentar atualizar o a senha do usuário.');
			}
		}else{

			return array('error' => 'Dados inválidos!');
		}
	}
}

?>