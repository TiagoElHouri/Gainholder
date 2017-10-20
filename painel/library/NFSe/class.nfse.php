<?php 

	class NFSe {

		public $numeroLote;

		public $cnpj 				= '40245953000134';
		public $inscricaoMunicipal 	= '060402564220';

		public $naturezaOperacao 			= '1';
		public $regimeEspecialTributacao 	= '1';
		public $optanteSimplesNacional 		= '2';
		public $incentivadorCultural 		= '2';

		public $issRetido 					= 2;

		public $codigoMunicipio 			= '4106902';

		/*************************************
		* ESTRUTURAS XML
		**************************************/

		// ESTRUTURA XML DO CABEÇALHO
		private function XMLCabecalho(){

			return '<?xml version="1.0" encoding="utf-8"?>'; 

		}

		private function XMLRps($lista){

			$xml = '';

			foreach ($lista as $item) {
				
				$xml .= '<Rps>
							<InfRps>
								<IdentificacaoRps>
									<Numero>' . $item['id'] . '</Numero>
									<Serie>F</Serie>
									<Tipo>1</Tipo>
								</IdentificacaoRps>
								<DataEmissao>' . date('Y-m-d') . 'T' . date('H:i:s') . '</DataEmissao>
								<NaturezaOperacao>' . $this->naturezaOperacao . '</NaturezaOperacao>
								<RegimeEspecialTributacao>' . $this->regimeEspecialTributacao . '</RegimeEspecialTributacao>
								<OptanteSimplesNacional>' . $this->optanteSimplesNacional . '</OptanteSimplesNacional>
								<IncentivadorCultural>' . $this->incentivadorCultural . '</IncentivadorCultural>
								<Status>1</Status>
								<Servico>
									<Valores>
										<ValorServicos>' . $item['valor'] . '</ValorServicos>    
										<IssRetido>' . $this->issRetido . '</IssRetido>
										<ValorIss>' . round(($this->issRetido/100) * $item['valor'],2) . '</ValorIss>      
										<ValorIssRetido>0</ValorIssRetido>
										<BaseCalculo>' . $item['valor'] . '</BaseCalculo>    
										<Aliquota>' . $this->issRetido/100 . '</Aliquota>
										<ValorLiquidoNfse>' . ($item['valor'] - round(($this->issRetido/100) * $item['valor'],2)) . '</ValorLiquidoNfse>    
									</Valores>
									<ItemListaServico>0604</ItemListaServico>
									<Discriminacao>' . $item['descricao'] . ' - R$ ' . $item['valor'] . '</Discriminacao>
									<CodigoMunicipio>' . $this->codigoMunicipio . '</CodigoMunicipio>
								</Servico>
								<Prestador>
									<Cnpj>' . $this->cnpj . '</Cnpj>                                                                  
									<InscricaoMunicipal>' . $this->inscricaoMunicipal . '</InscricaoMunicipal>
								</Prestador>
								<Tomador>
									<IdentificacaoTomador>
										<CpfCnpj>
											<Cpf>' . str_replace(array('.','-'), array('',''), $item['cpf']) . '</Cpf>
										</CpfCnpj>
									</IdentificacaoTomador>
									<RazaoSocial>' . $item['tomador'] . '</RazaoSocial>
									<Endereco>
										<Endereco>Bento Viana</Endereco>                          
										<Numero>994</Numero>
										<Complemento></Complemento>
										<Bairro>Agua Verde</Bairro> 
										<Uf>PR</Uf>
										<Cep>80240110</Cep>
									</Endereco>
									<Contato>
										<Telefone></Telefone>
										<Email></Email>
									</Contato>
								</Tomador>
							</InfRps>
						</Rps>';
			}

			return $xml;

		}

		public function GerarLoteRps($lista){

			$xml  = $this->XMLCabecalho();
			$xml .= "\n" . '
					<EnviarLoteRpsEnvio>
						<LoteRps>
							<NumeroLote>' . $this->numeroLote . '</NumeroLote>                                                                               
							<Cnpj>' . $this->cnpj . '</Cnpj>                                                                                
							<InscricaoMunicipal>' . $this->inscricaoMunicipal . '</InscricaoMunicipal>                                                        
							<QuantidadeRps>' . count($lista) . '</QuantidadeRps>
							<ListaRps>';
			$xml .= 		$this->XMLRps($lista);
			$xml .=			'</ListaRps>
						</LoteRps>
					</EnviarLoteRpsEnvio>';

			return $xml;

		}

	}

 ?>