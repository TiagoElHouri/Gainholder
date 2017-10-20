<?php

	/********************************
	 * MODEL DE CONTEÚDOS
	 * ******************************/

	class ConteudoModel{

		const TABLE = "conteudos";
		private $mysql;

		public function __construct(){

			$this->mysql = new Mysql();
		}

		//TRATA OS ADMINISTRADORES PARA SEREM INSERIDOS NO BANCO
		public function insert($dados){

			if(is_array($dados)){

				$separador = fieldColumnSeparator($dados['login']);
				$sqlInsert = "INSERT INTO ".self::TABLE." (".$separador['fields'].") VALUES(:email,:senha,:permissoes,:status)";
				$campos    = array('email' => $dados['login']['email'], 'senha' => $dados['login']['senha'], 'permissoes' => $dados['login']['permissoes'], 'status' => $dados['login']['status']);
				$executar  = $this->mysql->execute($sqlInsert,$campos);

				if($executar){

					$usuarioModel   = new UsuarioModel();
					$inserirUsuario = $usuarioModel->insert($dados);
					if(isset($inserirUsuario['success'])){

						//ADICIONA O ID DO USUÁRIO CADASTRADO
						$lastId = $usuarioModel->getLastId();
						$campos = array('usuarioId' => $lastId);
						$update = $this->update($campos,$this->getLastId());

						if(isset($update['success'])){

							$result['success'] = "Dados cadastrados com sucesso!";
						}else{

							$deleteLogin  = $this->delete($this->getLastId());	
							if(isset($deleteLogin['success'])){

								$deleteUsuario = $usuarioModel->delete($lastId);
								if(isset($deleteUsuario['success'])){

									$result['success'] = "Deletado Usuário e Login por erro na operação!";
								}else{

									$result['error'] = "Erro ao remover usuário!";	
								}
							}else{

								$result['error'] = "Erro ao remover login!";
							}
						}
					}else{

						$result['error']  = "Não foi possível realizar o cadastro.";
					}
				}else{

					$result['error']  = "Não foi possível realizar o cadastro.";
				}
			}else{

				$result['error'] = "Não foi possível realizar o cadastro.";
			}

			return $result;
		}

		// INSERE UMA UNICA LINHA ESPECÍFICA
		public function insertRow($dados){

			if(is_array($dados)){

				$separador = fieldColumnSeparator($dados['login']);
				$sqlInsert = "INSERT INTO ".self::TABLE." (".$separador['fields'].") VALUES(:email,:senha,:status,:usuarioId,:permissoes)";
				$campos    = array(
									'usuarioId'  => $dados['login']['usuarioId'],
									'email'      => $dados['login']['email'], 
									'senha'      => $dados['login']['senha'], 
									'status'     => $dados['login']['status'], 
									'permissoes' => $dados['login']['permissoes']
								);

				$executar  = $this->mysql->execute($sqlInsert,$campos);

				if($executar){

					$result['success'] = "Usuário cadastrado com sucesso!";
				}else{

					$result['error']  = "Não foi possível realizar o cadastro.";
				}
			}else{

				$result['error'] = "Não foi possível realizar o cadastro.";
			}

			return $result;
		}

		//TRATA OS ADMINISTRADORES PARA SEREM EDITADOS E ATUALIZADOS NO BANCO
		public function update($dados,$cond){

	  		$fieldsEdit = updateSeparator($dados);// RETORNA UMA QUERY DINAMICA
	        $sqlEditar  = "UPDATE ".self::TABLE." SET ".$fieldsEdit['result']." WHERE id = ".$cond;
	        $campos     = array("");
	        $editarEst  = $this->mysql->execute($sqlEditar,$campos);

	        if($editarEst){

	        	$resultado['success'] = "Atualizado com sucesso!";
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

					$resultado['success'] = "Usuario removido.";
				}else{

					$resultado['error'] = "Erro ao remover";
				} 
			}else{

				$resultado['error'] = "Erro ao remover";
			}

			return $resultado;
		}

		//RECUPERA UM LISTA DE DADOS
		public function getList($condicao){

			$sqlListar = "SELECT l.id as loginId, u.id as usuarioId, email, u.nome as nomeUsuario, status, permissoes FROM ".self::TABLE." l 
						  INNER JOIN usuarios u ON (u.id = l.usuarioId) $condicao ";

			$lista = $this->mysql->getList($sqlListar);

			if(!in_array(null, $lista)){

				$resultado = $this->makeList($lista);
			}else{

				$resultado['error'] = "Nenhum resultado encontrado.";
			}

			return $resultado;
		}

		//RETORNA UMA LINHA ESPECÍFICA
		public function getRow($campos, $cond){

			$sqlDetalhar = "SELECT {$campos} FROM ".self::TABLE." l 
							INNER JOIN usuarios u ON (u.id = l.usuarioId) {$cond}";

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

		//TRANSFORMA OS RESULTADOS EM OBJETO
		public function loadObjectsFromSql($row){

			$administrador = new Administrador($row->loginId);
			$administrador->setEmail(isset($row->email) ? $row->email : " ");
			$administrador->setStatus(isset($row->status) ? $row->status : 0);
			$administrador->setPermissoes(isset($row->permissoes) ? $row->permissoes : " ");

			$usuario = new Usuario(isset($row->usuarioId) ? $row->usuarioId : -1);

			if(isset($row->nomeUsuario)){

				$usuario->setNome($row->nomeUsuario);
			}

			$administrador->setUsuario($usuario);

			return $administrador;
		}
	}
?>