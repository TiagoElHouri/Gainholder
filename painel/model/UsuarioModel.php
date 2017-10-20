<?php

	/********************************
	 * MODEL DE USUÁRIOS
	 * ******************************/

	class UsuarioModel{

		const TABLE = "usuarios";
		private $mysql;

		public function __construct(){
			$this->mysql = new Mysql();
		}

		//TRATA OS DADOS PARA SEREM INSERIDOS NO BANCO
		public function insert($dados,$status=null){

			if(is_array($dados)){

				$separador = fieldColumnSeparator($dados['usuario']);
				$sqlInsert = "INSERT INTO ".self::TABLE." (".$separador['fields'].") VALUES(:nivel,:nome,:fotoPerfil,:sexo,:dataNascimento,:telefone,:celular,:cpf)";
				$campos    = array(
								'nivel'    		 => $dados['usuario']['nivelId'],
								'nome'           => $dados['usuario']['nome'],
								'fotoPerfil'     => $dados['usuario']['fotoPerfil'],
								'sexo'           => $dados['usuario']['sexo'],
								'dataNascimento' => $dados['usuario']['dataNascimento'],
								'telefone' 		 => $dados['usuario']['telefone'],
								'celular'  		 => $dados['usuario']['celular'],
								'cpf'      		 => $dados['usuario']['cpf']
							);

				$executar  = $this->mysql->execute($sqlInsert,$campos);

				if($executar){

					if($status != null){

						$lastId = $this->getLastId();
						$dados['login']['usuarioId'] = $lastId;
						$dados['login']['permissoes'] = "";

						$administradorModel = new AdministradorModel();
						$inserirLogin       = $administradorModel->insertRow($dados);

						if(isset($inserirLogin['success'])){

							$result['success'] = "Dados cadastrados com sucesso!";
						}else{

							$deleteLogin  = $this->delete($this->getLastId());
							if(isset($deleteLogin['success'])){

								$result['success'] = "Deletado Usuário por erro na operação!";
							}else{

								$result['error'] = "Erro ao remover login!";
							}
						}
					}else{

						$result['success'] = "Dados cadastrados com sucesso!";
					}
				}else{

					$result['error']  = "Não foi possível realizar o cadastro.";
				}
			}else{

				$result['error'] = "Não foi possível realizar o cadastro.";
			}

			return $result;
		}

		//TRATA OS DADOS PARA SEREM EDITADOS E ATUALIZADOS NO BANCO
		public function update($dados,$cond){

			$fieldsEdit = updateSeparator($dados['usuario']);// RETORNA UMA QUERY DINAMICA
	        $sqlEditar  = "UPDATE ".self::TABLE." SET ".$fieldsEdit['result']." WHERE id = ".$cond;
	        $campos     = array("");

	        $editarEst  = $this->mysql->execute($sqlEditar,$campos);

	        if($editarEst){

	        	$administradorModel  = new AdministradorModel();
	        	$updateLogin = $administradorModel->update($dados['login'], $dados['login']['id']);

				if(isset($updateLogin['success'])){

					$resultado['success'] = "Atualizado com sucesso!";
				}else{

					$resultado['error']  = "Não foi possivel editar o usuário.";
				}	
	        }else{

	        	$resultado['error']  = "Não foi possivel editar o usuário.";
	        }

	        return $resultado;
		}

		//DELETA UM DADO ESPECÍFICO PELO ID
		public function delete($id){

			if(is_numeric($id)){

				$sqlDelete = "DELETE FROM ".self::TABLE." WHERE id=:id";
				$campos    = array("id" => $id);
				$excluir   = $this->mysql->execute($sqlDelete,$campos);

				if($excluir){

					$resultado['success'] = "Usuário removido.";
				}else{

					$resultado['error'] = "Não foi possível excluir esse usuário";
				}
			}else{

				$resultado['error'] = "Não foi possível excluir esse usuário";
			}

			return $resultado;
		}

		//RECEBE UMA LISTA COM TODOS OS REGISTROS
		public function getList($condicao){

			$sqlListar = "SELECT u.id as usuarioId, l.id as loginId, nivelId, nome, fotoPerfil, sexo, dataNascimento, telefone, celular, cpf, email, status  FROM ".self::TABLE." u
						  INNER JOIN login l ON (l.usuarioId = u.id) $condicao ";

			$lista = $this->mysql->getList($sqlListar);

			if(!in_array(null, $lista)){

				$resultado = $this->makeList($lista);
			}else{

				$resultado['error'] = "Nenhum resultado encontrado.";
			}

			return $resultado;
		}

		//RECEBE UM REGISTRO ESPECÍFICO PELO ID
		public function getRow($campos, $cond){

			$sqlDetalhar = "SELECT {$campos} FROM ".self::TABLE." u 
							INNER JOIN login l ON (l.usuarioId = u.id) {$cond}";

			$campos   = array("");
			$detalhar = $this->mysql->getRow($sqlDetalhar,$campos);

			if($detalhar){

				$resultado['success'] = $this->makeList($detalhar);
			}else{

				$resultado['error'] = "Usuário não encontrado.";
			}

			return $resultado;
		}

		//RETORNA O ÚLTIMO ID INSERIDO NA TABELA
		public function getLastId(){

			$sqlLastId = "SELECT id FROM " .self::TABLE." ORDER BY id DESC LIMIT 1";
			$dados     = array("");
			$lastId    = $this->mysql->getRow($sqlLastId,$dados);

			if(!empty($lastId)){

				$result = $lastId->id;
			}else{

				$result = null;
			}

			return $result;
		}

		/**
		*  CRIA UMA LISTA DE OBJETOS ATRAVÉS DE UMA QUERY EXECUTADA
		*  @param query executada 
		*  @return array ou nulo
		*/
		public function makeList($list){

			if(!empty($list) && $list != null){

				if(count($list) > 0){

					$result = array();
					if(!is_object($list)){

						foreach($list as $row):

						    array_push($result, $this->loadObjectsFromSql($row));

						endforeach;

					}else{

						$result = $this->loadObjectsFromSql($list);
					}
				}else{

					$result = null;
				}
			}else{

				$result = null;
			}

			return $result;
		}

		/**
        * TRATA A IMAGEM PARA SER INSERIDA NO BANCO E SALVA NA PASTA DE FOTOS DO EXEMPLOS
        * @return string
        */
		public function imagemUpload($imagem,$pasta){

			$resultado = "";

			if(is_array($imagem)){

				if($imagem != null){

					$extensoesPermitidas = array('.jpg','.png','.gif','.svg');

					//TRATA A IMAGEM PARA SER ARMAZENADA NO BANCO
					$ext        = strtolower(substr($imagem['name'],strrpos($imagem['name'],".")));
					$imagemNome = base64_encode($imagem['name'].rand(0,10000));

					$pasta = "../".URL_PATH_UPLOAD.$pasta.'/';

					if(in_array($ext, $extensoesPermitidas)){

						$imagemNome = date('Y-m-d-H-i-s').$imagemNome;

						$upload = new UploadArquivo($imagem, 300);

						// PASTA PADRÃO PARA SER ARMAZENADO O ARQUIVO
						$upload->setPath($pasta);

						// NOME QUE SERÁ SALVO O ARQUIVO NA PASTA
						$upload->setName($imagemNome);

						// REALIZA O UPLOAD
						$uploadArquivo = $upload->upload("", true);

						if($uploadArquivo['Success']){

							$resultado = $imagemNome.$ext;

						}else{

							$resultado = "";
						}

					}else{

						$resultado = "";
					}
				}
			}else{

				$resultado = $imagem;
			}

			return $resultado;
		}

		//TRANSFORMA OS RESULTADOS EM OBJETO
		public function loadObjectsFromSql($row){

			$usuario = new Usuario(isset($row->usuarioId) ? $row->usuarioId : -1);
			$usuario->setNivel(isset($row->nivelId) ? $row->nivelId : '');
			$usuario->setNome(isset($row->nome) ? $row->nome : '');
			$usuario->setFotoPerfil(isset($row->fotoPerfil) ? $row->fotoPerfil : '');
			$usuario->setSexo(isset($row->sexo) ? $row->sexo : '');
			$usuario->setDataNascimento(isset($row->dataNascimento) ? $row->dataNascimento : '');
			$usuario->setTelefone(isset($row->telefone) ? $row->telefone : '');
			$usuario->setCelular(isset($row->celular) ? $row->celular : '');
			$usuario->setCpf(isset($row->cpf) ? $row->cpf : '');

			$login = new Login(isset($row->loginId) ? $row->loginId : -1);

			if(isset($row->email)){

				$login->setEmail($row->email);
			}

			if(isset($row->senha)){

				$login->setSenha($row->senha);
			}

			if(isset($row->status)){

				$login->setStatus($row->status);
			}

			$usuario->setLogin($login);

			return $usuario;
		}
	}
?>