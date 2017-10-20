	<?php
		/**
		 * CLASSE RESPONSÁVEL POR OBTER CEP E FRETE UTILIZANDO
		 * WEB SERVICE DOS CORREIOS.
		 * 
		 * @author Fernando Matos
		 * @version 1.0 - 28/05/2011 04:55 
		 */
		// INCLUI FUNÇÃO XML2ARRAY
		require('../painel/library/xml2array.php');
		require('../painel/library/cURLFrete.php');
		require('../painel/library/phpQuery-onefile.php');

		class Correio {

			// PROPRIEDADES
			private $propRetorno;
			private $propServico;
			private $propPeso;
			private $propCepOrigem;
			private $propCepDestino;
			private $propFormato;
			private $propMaoPropria;
			private $propAvisoDeRecebimento;
			private $propValorDeclarado;

			// MÉTODOS
			public function __construct($propCepDestino){

				$this->CepDestino = $propCepDestino; 			// = 19900001;
			}

			/**
			 * CONSULTA CEP ATRAVÉS DO CEP
			 * 
			 * @param $propServico
			 * 		- PAC
			 * 		- SEDEX 
			 * 		- SEDEX10
			 * 		- SEDEXHOJE
			 * 		- ESEDEX
			 * 		- MALOTE 
			 * 		- NORMAL
			 * @param $propPeso
			 * 		- 500, 600, 1500 (Gramas)
			 * @param $propCepOrigem
			 * 		- 19902440, 8120000
			 * @param $propFormato 
			 * @param $propMaoPropria 
			 * 		- S, N
			 * @param $propAvisoDeRecebimento 
			 * 		- S, N
			 * @param $propValorDeclarado
			 * 		- 150, 300, 1850
			 */
			public function ConsultarFrete($propRetorno, $propServico, $propPeso, $propCepOrigem, $propFormato, $propMaoPropria, $propAvisoDeRecebimento, $propValorDeclarado){

				switch ($propServico) {
					case 'PAC':

						$propServico = '411006';

					break;

					case 'SEDEX':

						$propServico = '40010';

					break;

					case 'SEDEX10':

						$propServico = '40215';

					break;

					case 'SEDEXHOJE':

						$propServico = '40290';

					break;

					case 'ESEDEX':

						$propServico = '81019';

					break;

					case 'MALOTE':

						$propServico = '44105';

					break;

					case 'NORMAL':

						$propServico = '41017';

					break;

					default:

						$propServico = '0';

					break;
				}

				$this->Retorno			  = $propRetorno;			// = 'xml';
				$this->Servico			  = $propServico;			// = 40010;
				$this->Peso				  = $propPeso;				// = 1;
				$this->CepOrigem		  = $propCepOrigem;			// = 19902440;
				$this->Formato			  = $propFormato; 			// = 1;
				$this->MaoPropria		  = $propMaoPropria; 		// = 'N';
				$this->AvisoDeRecebimento = $propAvisoDeRecebimento;// = 'N';
				$this->ValorDeclarado	  = $propValorDeclarado; 	// = 0;

				$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";

				$url .= "?StrRetorno=" 			. 'xml';
				$url .= "&nCdServico=" 			. $this->Servico;
				$url .= "&nVlPeso=" 			. $this->Peso;
				$url .= "&sCepOrigem=" 			. $this->CepOrigem;
				$url .= "&sCepDestino=" 		. $this->CepDestino;
				$url .= "&nCdFormato=" 			. $this->Formato;
				$url .= "&sCdMaoPropria=" 		. $this->MaoPropria;
				$url .= "&sCdAvisoRecebimento=" . $this->AvisoDeRecebimento;
				$url .= "&nVlValorDeclarado=" 	. $this->ValorDeclarado;

				$curl 		 = cURLFrete($url);
				$code 		 = $curl['http_code'];
				$erro 		 = $curl['erro'];
				$erroCorreio = $curl['conteudo']['Erro'];

				if($code != 200 || $erro != 0 || $erroCorreio != 0) {

					$array = array('Valor' => '25.00', 'PrazoEntrega' => '5', 'ErroURL' => $url);
					return $array;
				}else {

					$curl['conteudo']['ErroURL'] = 0;
					return $curl['conteudo'];
				}
			}

			public function ConsultarCep(){

				//$url = 'http://cep.republicavirtual.com.br/web_cep.php?cep=' . $this->CepDestino . '&formato=xml';	

				//INICIA A BIBLIOTECA CURL
				//$ch = curl_init();

				$html = $this->simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
					'cepEntrada'=>$this->CepDestino,
					'tipoCep'   =>'',
					'cepTemp'   =>'',
					'metodo'    =>'buscarCep'
				));

				phpQuery::newDocumentHTML($html, $charset = 'utf-8');

				$dados = 
				array(
					'logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
					'bairro'    => trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
					'cidade/uf' => trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
					'cep'       => trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
				);

				if($dados['logradouro'] != '' && isset($dados['logradouro']) && $dados['bairro'] != '' && isset($dados['bairro'])&& $dados['cidade/uf'] != '' && isset($dados['cidade/uf']) && $dados['cep'] != '' && isset($dados['cep'])){

					$dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
					$dados['cidade']    = trim($dados['cidade/uf'][0]);

					$dados['uf']        = trim($dados['cidade/uf'][1]);
					unset($dados['cidade/uf']);

					$logradouroFaixaNumero = explode('-', $dados['logradouro']);
					$dados['logradouro']   = $logradouroFaixaNumero[0];
				}else{

					$erro['Erro'] = "CEP não válido para preenchimento automático dos dados.";
					$dados = $erro;
				}

				return $dados;
			}

			public function simple_curl($url,$post=array(),$get=array()){

				$url = explode('?',$url,2);
				if(count($url)===2){

					$temp_get = array();
					parse_str($url[1],$temp_get);
					$get = array_merge($get,$temp_get);
				}

				$ch = curl_init($url[0]."?".http_build_query($get));
				curl_setopt ($ch, CURLOPT_POST, 1);
				curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				return curl_exec ($ch);
			}

			public function __destruct(){

				/*$this->Retorno;
				$this->Servico;
				$this->Peso;
				$this->CepOrigem;
				$this->CepDestino;
				$this->Formato;
				$this->MaoPropria;
				$this->AvisoDeRecebimento;
				$this->ValorDeclarado;*/
			}

		}
	?>