<?php 

class UploadArquivo{


	/**
	* Class para upload de arquivos
	* 
	*/


	/**
	* Dados do arquivo
	* @var $file = recebe o arquivo
	* @var $name = recebe o nome da imagem
	* @var $tmpName = recebe o tmp_name do arquivo
	* @var $size = recebe o tamanho (kb) do arquivo
	* @var $sizeMax = define o tamanho máximo do arquivo
	* @var $ext = recebe a extensão do arquivo
	* @var $directoryFinal = define o diretório (+ nome) para onde o arquivo sereá enviado e com que nome
	* @var $errors = recebe os erros do arquivo
	* @var $path = pasta para onde o arquivo será mandado
	*/

	protected

	$file,

	$name,

	$tmpName,

	$size,

	$sizeMax,

	$ext,

	$directoryFinal,

	$errors,

	$path = "../../arquivos/jobs/";


	/**
	* Lista com possíveis erros do arquivo
	* @var $this->errors = array : erros da imagem
	*/

	protected

	$errorsList = array();


	/**
	* Pega as informações do arquivo enviado (método construtor)
	* @param $file = arquivo a ser enviado
	* @var $this->file = arquivo e armazana nessa mesma variável
	* @method $this->setTmpName() = pega o tmp_name do arquivo e armazana na variável $this->tmpName
	* @method $this->setName() = pega o nome do arquivo e armazena na variável $this->name
	* @method $this->setExt() = pega a extensão do arquivo e armazena na variável $this->ext
	*/

	public function __construct( $file , $cripto=false){

		$this->file = $file;

		$this->searchErrors();

		$this->setTmpName();

		$this->setName();

		$this->setExt();

	}


	/**
	* Trocando a para onde o arquivo será mandado
	* @param $path = novo diretório
	* @var $this->path = define um novo diretório para onde o arquivo será mandado (Original: 'uploads/')
	*/

	public function setPath( $path ){

		$this->path = $path;

		$this->setDirectoryFinal();

	}


	/**
	* Recebe o nome do arquivo
	* @param $name = novo nome da imagem
	*/

	public function setName( $name = null ){

		if( $name != null ){

			$this->name = $name . '.' . $this->ext;

			$this->setDirectoryFinal();

		}else{

			$this->name = $this->file['name'];

			$this->setDirectoryFinal();

		}

	}


	/**
	* Pega o tamanho do arquivo
	* @var $this->size = onde será armazanado o tamanho do arquivo em KB's
	*/

	protected function setSize(){

		$this->size = $this->file['size'];

	}


	/**
	* Pega o tmp_name do arquivo
	* @var $this->tmpName = onde o tmp_name do arquivo é armazanado
	*/

	protected function setTmpName(){

		$this->tmpName = $this->file['tmp_name'];

	}


	/**
	* Pega a exntensão do arquivo
	* @var $this->ext = onde será armazenada a extensão do arquivo
	*/

	protected function setExt(){

		$explode = explode( '.', $this->name );

		$this->ext = end( $explode );

	}

	public function getExt(){
		return $this->ext;
	}

	/**
	* Cria o diretório final do arquivo a ser enviado
	* @var $this->directoryFinal = str com o diretório
	*/

	protected function setDirectoryFinal(){

		$this->directoryFinal = $this->path . $this->name;

	}


	/**
	* Escolhe o tipo de arquivo a ser enviado
	* @param $type = o tipo do arquivo a ser enviado ('Images', 'Audio', 'Video')
	* @var $allowedForImages = array : tipos de imagens permitidas
	* @var $allowedForAudio = array : tipos de arquivos de áudio permitidos
	* @var $allowedForVideo = array : tipos de arquivos de vídeo permitidos
	*/

	public function typeAllowed( $type ){


		$allowedForImages = array( 'JPEG', 'jpeg', 'JPG', 'jpg', 'GIF', 'gif', 'PNG', 'png', 'BMP', 'bmp' );

		$allowedForAudio = array( 'MP3', 'mp3', 'WMA', 'wma', 'AAC', 'aac', 'WMA', 'wma', 'OGG', 'ogg', 'AC3', 'ac3' );

		$allowedForVideo = array( 'AVI', 'avi', 'WMV', 'wmv', 'MP4', 'mp4', 'FLV', 'flv' );


		switch( $type ){

		case 'Images':

			if( !in_array( $this->ext, $allowedForImages ) ){

				die( "<script>alert('O arquivo não é uma imagem, por isso o upload foi cancelado.');</script>" );

			}

		break;


		case 'Audio':

			if( !in_array( $this->ext, $allowedForAudio ) ){

				die( "<script>alert('O arquivo não um arquivo de áudio, por isso o upload foi cancelado.');</script>" );

			}

		break;


		case 'Video':

			if( !in_array( $this->ext, $allowedForVideo ) ){

				die( "<script>alert('O arquivo não é um arquivo de vídeo, por isso o upload foi cancelado.');</script>" );

			}

		break;

		}

	}


	/**
	* Define o tamanho máximo do arquivo a ser enviado
	* @param $size_max = tamanho máximo (int)
	* @param $type = tipo de unidade de medida ('KB', 'MB', 'GB')
	*/

	public function sizeMax( int $size_max, $type ){

		switch(strtolower($type)){

		case "kb":

			$kb = $size_max;

			$this->sizeMax = $kb;

			if( $this->sizeMax > $this->size ){

				die( "O arquivo é muito grande, o máximo é ".$kb."KB" );

			}

		break;


		case "mb":

			$mb = $size_max;

			$this->sizeMax = 1024 * 1024 * $mb;

			if( $this->sizeMax > $this->size ){

				die( "O arquivo é muito grande, o máximo é ".$mb."MB" );

			}

		break;


		case "gb":

			$gb = $size_max;

			$this->sizeMax = 1024 * 1024 * 1024 * $gb;

			if( $this->sizeMax > $this->size ){

				die( "O arquivo é muito grande, o máximo é ".$gb."MB" );

			}

		break;


		default:

			die( "Unidade de medida de tamenho de arquivo inválida" );

		break;

		}

	}


	/**
	* Verifica se há erros no arquivo
	* @var $this->errors = fica armazanados os erros do arquivo
	* @var $this->errorsList = erros em string (Erros by Thiago Belem (http://blog.thiagobelem.net))
	* @return morre se huver erros
	*/

	protected function searchErrors(){

		$this->errors = $this->file['error'];


		$this->errorsList[0] = 'Não houve erro';

		$this->errorsList[1] = 'O arquivo no upload é maior do que o limite do PHP';

		$this->errorsList[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';

		$this->errorsList[3] = 'O upload do arquivo foi feito parcialmente';

		$this->errorsList[4] = 'Não foi feito o upload do arquivo';


		if( $this->errors != 0 ){

			die( "<b>Ao fazer o upload, erros foram encontrados:</b> " . $this->errorsList[ $this->errors ] );

		}

	}


	/**
	* Faz o upload do arquivo caso não haja erros
	* @param $msg = mensagem de sucesso caso o arquivo seja enviado
	* @var $upload = faz o upload do arquivo
	*/

	public function upload( $msg = null ){

		$upload = move_uploaded_file($this->tmpName, $this->directoryFinal);

		if( $upload ){

			if( $msg == null ){

				$mensagem =  array('Success' => 'Upload realizado com sucesso!');

			}else{

				$mensagem = array('Success' => $msg);

			}

		}else{

			$mensagem = array('Error' => 'Erro ao realizar o upload do arquivo');
		}

		return $mensagem;
	}

}

?>