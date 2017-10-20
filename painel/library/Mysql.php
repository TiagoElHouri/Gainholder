<?php 

	/************************************************************************
	* CLASSE QUE CONECTARÁ COM O BANCO E REALIZARÁ AS QUATRO OPERAÇÕES (CRUD)
	*************************************************************************/
	
	class Mysql{

		private $server     = HOST;
		private $user       = USER;
		private $password   = PASSWORD;
		private $dbname     = DB_NAME;
		private $connection;

		public function __construct(){
			try{
				$this->connection = new PDO("mysql:host={$this->server};dbname={$this->dbname};charset=utf8",$this->user,$this->password);
			}catch(PDOException $e){
				die ("Não foi possivel estabelecer a conexão com o banco de dados. Erro: ".$e->getMessage()." Código: ".$e->getCode());
			}
		}

		// CLASSE PARA EXECUTAR UM COMANDO NO BANCO (INSERT, UPDATE, DELETE)
		public function execute($sql, array $dados){
			if(is_string($sql)){
				$statement = $this->connection->prepare($sql);

				if(count($dados) > 0){
					
					foreach ($dados as $coluna => $valor) {
						$statement->bindValue(':'.$coluna,$valor);
					}

					if($statement->execute()){
						$resultado = true;
					}else{
						$resultado = false;
					}

				}else{
					$resultado = false;
				}
			}else{
				$resultado = false;
			}

			return $resultado;
		}

		// RETORNAR UM LISTA DE DADOS
		public function getList($sql){
			$lista = array();
			if(is_string($sql)){
				$statement = $this->connection->query($sql);
				$resultado = $statement->fetchAll(PDO::FETCH_CLASS);
				
				if(count($resultado) > 0){
					foreach ($resultado as $linha){
						array_push($lista, $linha);
					}
				}else{
					$lista = array(null);
				}
			}else{
				$lista = array(null);
			}

			return $lista;
		}

		// RETORNAR SOMENTE UM LINHA DA TABELA
		public function getRow($sql, array $dados){
			if(is_string($sql)){
				$statement = $this->connection->prepare($sql);

				if(count($dados) > 0){
					
					foreach ($dados as $coluna => $valor) {
						$statement->bindValue(':'.$coluna,$valor);
					}

				}

				if($statement->execute()){
					$resultado = $statement->fetch(PDO::FETCH_OBJ);
				}else{
					$resultado = false;
				}

			}else{
				$resultado = false;
			}

			return $resultado;
		}
		
	}
?>