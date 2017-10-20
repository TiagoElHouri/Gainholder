<?php

	/********************************
	 * MODEL DE EXEMPLO
	 * ******************************/

	class ExemploModel{

		const TABLE = "exemplos";
		private $mysql;

		public function __construct(){

			$this->mysql = new Mysql();
		}

		//TRATA OS DADOS PARA SEREM INSERIDOS NO BANCO
		public function insert($dados){

			if(is_array($dados)){

				$separador = fieldColumnSeparator($dados['exemplo']);
				$sqlInsert = "INSERT INTO ".self::TABLE." (".$separador['fields'].") VALUES(:campo1,:campo2,:campo3,:campo4)";
				$campos    = array(
								'campo1' => $dados['exemplo']['campo1'],
								'campo2' => $dados['exemplo']['campo2'],
								'campo3' => $dados['exemplo']['campo3'],
								'campo4' => $dados['exemplo']['campo4']
							);

				$executar  = $this->mysql->execute($sqlInsert,$campos);

				if($executar){

					$result['success'] = "Dados cadastrados com sucesso!";
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

				$separador = fieldColumnSeparator($dados['exemplo']);
				$sqlInsert = "INSERT INTO ".self::TABLE." (".$separador['fields'].") VALUES(:campo1,:campo2,:campo3,:campo4)";
				$campos    = array(
									'campo1' => $dados['exemplo']['campo1'],
									'campo2' => $dados['exemplo']['campo2'],
									'campo3' => $dados['exemplo']['campo3'],
									'campo4' => $dados['exemplo']['campo4']
							);

				$executar  = $this->mysql->execute($sqlInsert,$campos);

				if($executar){

					$result['success'] = "Dados cadastrados com sucesso!";
				}else{

					$result['error']  = "Não foi possível realizar o cadastro.";
				}
			}else{

				$result['error'] = "Não foi possível realizar o cadastro.";
			}

			return $result;
		}

		//TRATA OS EXEMPLOS PARA SEREM EDITADOS E ATUALIZADOS NO BANCO
		public function update($dados,$cond){

			$fieldsEdit = updateSeparator($dados['exemplo']);// RETORNA UMA QUERY DINAMICA
			$sqlEditar  = "UPDATE ".self::TABLE." SET ".$fieldsEdit['result']." WHERE id = ".$cond;
			$campos     = array("");
			$editarEst  = $this->mysql->execute($sqlEditar,$campos);

			if($editarEst){

				$resultado['success'] = "Atualizado com sucesso!";
			}else{

				$resultado['error']   = "Não foi possivel editar.";
			}

			return $resultado;
		}

		//DELETA UM EXEMPLO ESPECÍFICO PELO ID
		public function delete($id){

			if(is_numeric($id)){

				$sqlDelete = "DELETE FROM ".self::TABLE." WHERE id=:id";
				$campos    = array("id" => $id);
				$excluir   = $this->mysql->execute($sqlDelete,$campos);

				if($excluir){

					$resultado['success'] = "Remoção realizada com sucesso.";
				}else{

					$resultado['error'] = "Erro ao remover";
				}
			}else{

				$resultado['error'] = "Erro ao remover";
			}

			return $resultado;
		}

		//RECUPERA UMA LISTA DE EXEMPLOS
		public function getList($condicao){

			$sqlListar = "SELECT id, campo1, campo2, campo3, campo4 FROM ".self::TABLE." 
						  $condicao ";

			$lista = $this->mysql->getList($sqlListar);

			if(!in_array(null, $lista)){

				$resultado = $this->makeList($lista);
			}else{

				$resultado['error'] = "Nenhum resultado encontrado.";
			}

			return $resultado;
		}

		//RETORNA UMA LINHA ESPECÍFICA COM O EXEMPLO
		public function getRow($campos, $cond){

			$sqlDetalhar = "SELECT {$campos} FROM ".self::TABLE." {$cond}";

			$campos   = array("");
			$detalhar = $this->mysql->getRow($sqlDetalhar,$campos);

			if($detalhar){

				$resultado['success'] = $this->makeList($detalhar);
			}else{

				$resultado['error'] = "Não encontrado.";
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
		*  CRIA UMA LISTA DE EXEMPLOS ATRAVÉS DE UMA QUERY EXECUTADA
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

			$exemplo = new Exemplo(isset($row->id) ? $row->id : -1);
			$exemplo->setCampo1(isset($row->campo1) ? $row->campo1 : null);
			$exemplo->setCampo2(isset($row->campo2) ? $row->campo2 : null);
			$exemplo->setCampo3(isset($row->campo3) ? $row->campo3 : null);
			$exemplo->setCampo4(isset($row->campo4) ? $row->campo4 : null);

			return $exemplo;
		}
	}
?>