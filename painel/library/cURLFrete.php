<?php 
	
	function cURLFrete($url) {
	    
	    $opcoes= array(
	        CURLOPT_RETURNTRANSFER => true,     // return web page
	        CURLOPT_HEADER         => false,    // don't return headers
	        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
	        CURLOPT_ENCODING       => "",       // handle all encodings
	        CURLOPT_USERAGENT      => "spider", // who am i
	        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
	        CURLOPT_CONNECTTIMEOUT => 10,      // timeout on connect
	        CURLOPT_TIMEOUT        => 10,      // timeout on response
	        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	    );
	
	    // INICIA A BIBLIOTECA CURL
	    $ch			= curl_init($url);
	    
	    // BUSCA NO ARRAY TODAS AS OPÇÔES A SEREM UTILIZADAS NO curl_setopt()
	    curl_setopt_array($ch, $opcoes);
	    
	    // PEGAO CONTEÚDO DA PÁGINA ACESSADA
	    $conteudo	= curl_exec($ch);
	    
	    // HAVENDO ERRO PEGA O SEU NUMERO
	    $erro		= curl_errno($ch);
	    
	    // HAVENDO MENSAGEM DE ERRO
	    $erromsg		= curl_error($ch);
	    
	    // PASSA PARA A VARIÁVEL $pagina O ARRAY DE INFORMAÇÔES REFERENTE A PÁGINA QUE ESTÁ SENDO ACESSADA
	    $pagina		= curl_getinfo($ch);
	    
	    // FECHA A CONEXÃO cURL
	    curl_close( $ch );
	
	    $pagina['erro']   = $erro;
	    $pagina['erromsg']  = $erromsg;
	    
	    if(!$conteudo) {
	    	$pagina['erro'] = 1;
	    }else {
		    if($pagina['content_type'] == 'text/xml; charset=iso-8859-1') {
		    	$xml_conteudo 		= xml2array($conteudo);
		    	$pagina['conteudo'] = $xml_conteudo['Servicos']['cServico'];
		    }else {
		    	$pagina['conteudo'] = '';
		    }
	    }
	    
	    return $pagina;

	}	
?>
