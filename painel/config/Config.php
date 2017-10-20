<?php

	// TIMEZONE & ENCODING
	date_default_timezone_set("Brazil/East");
	mb_internal_encoding('UTF-8');

	// DEFINIÇÕES POR AMBIENTE
    switch ($_SERVER['HTTP_HOST']) {

    	// AMBIENTE LOCAL
    	case 'localhost':

		    //CONFIGURAÇÃO URL RAIZ
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/projetos/gainholder/painel';
			define('URL',$url);	

    		// DIRETÓRIO
    		define('SITE_PATH',	'/projetos/gainholder');
    		define('SITE_HOME', '/projetos/gainholder/');

    		// BANCO DE DADOS
    		define('HOST',	   'localhost');
			define('DB_NAME',  'gainholder');
			define('USER',	   'root');
			define('PASSWORD', '');

			define('EMAIL_PRINCIPAL', '');

    	break;

   		// AMBIENTE DE HOMOLOGAÇÃO
    	case 'gainholder.com.br/homologacao':

   //  		define('URL',			'/cms/painel/');
   //  		define('SITE_PATH',				'/');
   //  		define('SITE_HOME',				'/');

   //  		define('HOST',			'localhost');
			// define('DB_NAME',		'pixd_gomob_appcms');
			// define('USER',			'pixd_palupa');
			// define('PASSWORD',		'palupa@2015');

			// define('EMAIL_PRINCIPAL', 'testes@pixd.com.br');

    	break;

      	// AMBIENTE DE PRODUÇÃO
    	case '':

    		define('URL',			'/painel/');
    		define('SITE_PATH',				'/');
    		define('SITE_HOME',				'/');

    		define('HOST',			'');
			define('DB_NAME',				'');
			define('USER',			'');
			define('PASSWORD',		'');

			define('EMAIL_PRINCIPAL', '');

    	break;
    }

    //API'S 
	define('FACEBOOK_KEY','');
	define('TWITTER_KEY','');
	define('GOOGLE_KEY','');

	//URL'S REDES SOCIAIS
	define('SITE_FACEBOOK','');
	define('SITE_TWITTER','');

	// DEFINIÇÕES DE E-MAIL
	define('EMAIL_HOST', 		   'mail.pixd.com.br');
	define('EMAIL_PORTA', 		   '587');
	define('EMAIL_SSL', 		   'tls');
	define('EMAIL_REMETENTE', 	   'palupa@pixd.com.br');
	define('EMAIL_REMETENTE_NOME', 'Palupa');
	define('EMAIL_USUARIO', 	   'palupa@pixd.com.br');
	define('EMAIL_SENHA', 		   '123@qwe');

	// CONSTANTES ERROS SISTEMA
	const ERROR_PAGE_NOT_FOUND   = "Página não encontrada.";
	const ERROR_ID_NOT_FOUND     = "Registro não encontrado.";
	const ERROR_CLASS_NOT_FOUND  = "Modulo não existente.";
	const ERROR_METHOD_ACTION    = "Essa ação não existe no módulo atual.";
	const ERROR_PERMISSION_PAGE  = "Você não possui permissão para acessar essa página.";
	const ERROR_MODULO_INCORRECT = "Módulo incorreto para realizar essa ação.";
	const ERROR_SEARCH_FORMAT    = "Formato inválido para realizar a busca.";

	// CONSTANTE PASTA PADRÃO UPLOAD 
	const URL_PATH_UPLOAD        = "assets/img/upload/";

	// AÇÕES ENTRE O FORMULÁRIO
	const INSERT                 = 1;
	const UPDATE                 = 2;

	// CONSTANTE PARA DEFINIR SE O SITE SER ACESSADO SER REDIRECIONADO PARA O PAINEL 0 - Não, 1 - Sim;
	const REDIRECT_PAINEL = 1;


?>