<?php  

	/************************************************************************
	* CLASSE QUE IRÁ GERAR UMA TABELA DINÂMICA
	*************************************************************************/
	
	class Tabela{

		private $cabecalho = array();
		private $linhas    = array();

		private $id;

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function setCabecalho(array $cabecalho){
			$this->cabecalho = $cabecalho;
		}

		public function getCabecalho(){
			return $this->cabecalho;
		}

		public function add_linha(array $linhas){
			$this->linhas[] = $linhas;
		}

		public function getLinha(){
			return $this->linhas;
		}

		public function generate(){

			$template = "";

			$template .= "<table class='table table-striped'>";

				if(!empty($this->cabecalho) && is_array($this->cabecalho)){

					$template .= "<thead><tr>";

					$cabecalho = $this->cabecalho;

						foreach($cabecalho as $linhaTopo){

							$template .= "<th><h3>".$linhaTopo."</h3></th>";
						}

					$template .= "</tr></thead>";
				}

				if(!empty($this->linhas) && is_array($this->linhas)){

					$linhas = $this->linhas;

					$qtdCabecalho = count($this->cabecalho);
					$qtdLinhas 	  = count($this->linhas[0]);

					if($qtdCabecalho == $qtdLinhas){
					
						foreach($linhas as $linha){

							$template .= "<tr>";
								foreach($linha as $coluna){
									$template .= "<td>".$coluna."</td>";
								}
							$template .= "</tr>";
						}
					
					}else{
						$template .= "<tr>
										<td colspan=".$qtdCabecalho."><strong>".$linhas[0][0]."</strong></td>
									</tr>";
					}
				}

			$template .= "</table>";


			return $template;

		}

	}

?>