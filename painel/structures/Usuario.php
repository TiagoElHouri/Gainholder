<?php  

	/*******************************************************
	* GETERS E SETERS - TABELA {USUÁRIO}
	*********************************************************/

	class Usuario{

		private $id;
		private $nome;
		private $fotoPerfil;
		private $sexo;
		private $dataNascimento;
		private $telefone;
		private $celular;
		private $cpf;
		private $nivel;

		//OBJETO LOGIN
		private $login;

		public function __construct($id=-1){
			$this->id = $id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setFotoPerfil($fotoPerfil){
			$this->fotoPerfil = $fotoPerfil;
		}

		public function getFotoPerfil(){
			return $this->fotoPerfil;
		}

		public function setSexo($sexo){
			$this->sexo = $sexo;
		}

		public function getSexo(){
			return $this->sexo;
		}

		public function setDataNascimento($dataNascimento){
			$this->dataNascimento = $dataNascimento;
		}

		public function getDataNascimento(){
			return $this->dataNascimento;
		}

		public function setTelefone($telefone){
			$this->telefone = $telefone;
		}

		public function getTelefone(){
			return $this->telefone;
		}

		public function setCelular($celular){
			$this->celular = $celular;
		}

		public function getCelular(){
			return $this->celular;
		}

		public function setCpf($cpf){
			$this->cpf = $cpf;
		}

		public function getCpf(){
			return $this->cpf;
		}

		public function setNivel($nivel){
			$this->nivel = $nivel;
		}

		public function getNivel(){
			return $this->nivel;
		}

		// OBJETO LOGIN
		public function setLogin(Login $login){
			$this->login = $login;
		}

		public function getLogin(){
			return $this->login;
		}
	}
?>