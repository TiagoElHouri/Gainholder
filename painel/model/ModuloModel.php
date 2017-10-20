<?php  

	/********************************
	 * MODEL DE MODULOS
	 * ******************************/

	class ModuloModel{

		const TABLE = "modulos";
		private $mysql;

		public function __construct(){
			$this->mysql = new Mysql();
		}

		//TRATA OS DADOS PARA SEREM INSERIDOS NO BANCO
		public function insert($dados){
			// DO NOTHING
		}

		//TRATA OS DADOS PARA SEREM EDITADOS E ATUALIZADOS NO BANCO
		public function update($dados,$cond){
			// DO NOTHING
		}

		//DELETA UM DADO ESPECÍFICO PELO ID
		public function delete($id){
			// DO NOTHING
		}

		//RECEBE UMA LISTA COM TODOS OS REGISTROS
		public function getList(){

			$sqlListar = "SELECT id_modulo, id_pai, nome, icone, url, status FROM ".self::TABLE." WHERE status = 1";
			$lista     = $this->mysql->getList($sqlListar);

			if(!in_array(null, $lista)){

				$resultado = $this->makeList($lista);
			}else{

				$resultado['error'] = "Nenhum resultado encontrado.";
			}

			return $resultado;
		}

		//RECEBE UM REGISTRO ESPECÍFICO PELO ID
		public function getListModulos($campos, $cond){

			$sqlDetalhar = "SELECT {$campos} FROM ".self::TABLE." {$cond}";
			$campos = array("");
			$detalhar = $this->mysql->getList($sqlDetalhar);

			if($detalhar){

				$resultado['success'] = $this->makeList($detalhar);
			}else{

				$resultado['error'] = "Modulo não encontrado.";
			}

			return $resultado;
		}		

		//RECEBE UM REGISTRO ESPECÍFICO PELO ID
		public function getRow($campos, $cond){

			$sqlDetalhar = "SELECT {$campos} FROM ".self::TABLE." {$cond}";
			$campos = array("");
			$detalhar = $this->mysql->getRow($sqlDetalhar,$campos);

			if($detalhar){

				$resultado['success'] = $this->makeList($detalhar);
			}else{

				$resultado['error'] = "Modulo não encontrado.";
			}

			return $resultado;
		}

		//RETORNA O ÚLTIMO ID INSERIDO NA TABELA
		public function getLastId(){

			$sqlLastId = "SELECT id FROM " .self::TABLE_NAME." ORDER BY id DESC LIMIT 1";
			$dados = array("");
			$lastId = $this->mysql->getRow($sqlLastId,$dados);

			if (!empty($lastId)){

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
	     * RETORNA EM UM ARRAY OS DADOS DAS PERMISSÕES QUE O ADMINISTRADOR POSSUI
	     * @return array
	     */
	    public function getListPermissions($permissoes) {
	        $result = array();
	        if (is_array($permissoes) == true) {

	            // RETORNA EM UM ARRAY OS DADOS DAS PERMISSÕES QUE O ADMINISTRADOR POSSUI
	            for ($i = 0; $i < count($permissoes); $i++) {
	            	$modulo = $this->getListModulos("id_modulo, id_pai, nome, url, icone, status","WHERE id_modulo =".$permissoes[$i]->id_modulo.' OR  id_modulo = '.$permissoes[$i]->id_pai);
	                array_push($result, $modulo['success']);
	            }

	        }else{
	            $result = array('result' => null);
	        }
	        return $result;
	    }

		//TRANSFORMA OS RESULTADOS EM OBJETO
		public function loadObjectsFromSql($row){
			$modulo = new Modulos($row->id_modulo);
			$modulo->setNome($row->nome);
			$modulo->setUrl($row->url);
			$modulo->setIdPai($row->id_pai);
			$modulo->setIcone($row->icone);
			$modulo->setStatus($row->status);

			return $modulo;
		}
	}
?>