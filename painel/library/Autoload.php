<?php 

	function __autoload($classe){

		$diretorios = array('controllers','model','library','structures');

		foreach ($diretorios as $diretorio) {
			
			if(file_exists($diretorio."/".$classe.".php")){
			
				include($diretorio."/".$classe.".php");
				break;
			
			}else if(file_exists("../".$diretorio."/".$classe.".php")){
			
				include("../".$diretorio."/".$classe.".php");
				break;
			
			}else if(file_exists("painel/".$diretorio."/".$classe.".php")){
			
				include("painel/".$diretorio."/".$classe.".php");
				break;
			
			}else if(file_exists("../painel/".$diretorio."/".$classe.".php")){
			
				include("../painel/".$diretorio."/".$classe.".php");
				break;
			
			}


		}
	}

?>