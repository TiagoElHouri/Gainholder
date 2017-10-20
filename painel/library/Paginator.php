<?php
/**
* CLASSE GERA UMA PÁGINAÇÃO GENÉRICA
*
*/
class Paginator{

    public $tabela;
    public $campos;
    public $cond;
    public $limite;
    public $url; 
    public $pag;
    public $style;
    public $urlExtra;
    public $maxLinks;

    public function __construct($tabela, $campos="*", $cond, $limite, $url, $pag, $maxLinks=2,$style='pagination'){
    	$this->tabela = $tabela;
    	$this->cond = $cond;
        $this->campos = $campos;
    	$this->limite = $limite;
    	$this->url = $url;
    	$this->pag = $pag;
    	$this->maxLinks = $maxLinks;
        $this->style = $style;
    }

    /**
    * REALIZA A QUERY NECESSÁRIA PARA TORNAR OS RESULTADOS NA LISTAGEM DINÂMICOS
    * @return integer
    */
    private function read(){
    	$sql = new MySQL(); 
    	$sqlList = "SELECT {$this->campos} FROM {$this->tabela} {$this->cond}";
        //echo $sqlList;exit;
    	$query = $sql->getList($sqlList);
    	$total = count($query);
      
    	//TOTAL DE RESULTADOS 
    	if($total > $this->limite){
    		$totalPaginas = ceil($total/$this->limite);
    	}else{
            $totalPaginas = 0;
        }

    	return $totalPaginas;
    }

    /**
    * CRIA A ESTRUTURA DA PAGINAÇÃO JÁ COM A BUSCA DINÂMICA SENDO EXECUTADA
    * @return string
    */
    public function makeInterface(){
        
        /* Configurações variáveis de ambiente*/
        $navStyle = 'style="text-align:center;"';
        $ulClass = "class='".$this->style."'";
        $liPrev =  "aria-label='Previous'";
        $liFirstSymbol = "<span aria-hidden='true'>Primeira</span>";
        $liPrevSymbol = "<span aria-hidden='true'><</span>";
        $liNext = "aria-label='Next'";
        $liNextSymbol = "<span aria-hidden='true'>></span>";
        $liLastSymbol = "<span aria-hidden='true'>Última</span>";

    	$paginas = $this->read();
        //echo $paginas;exit;
        if($paginas != 0){ 
            
        	$pagination = "<nav {$navStyle}>";

      		$pagination .= 	"<ul {$ulClass}>";

      		// PRIMEIRA PÁGINA 
    	   	$pagination	.= 		"<li>";
    	    $pagination .=   		"<a href='".$this->url."1' {$liPrev}>";
    	    $pagination .=    			$liFirstSymbol;
    	    $pagination .=  		'</a>';
    	    $pagination .=		"</li>";

            //RECUPERA PÁGINA ANTERIOR
            $numPaginaAnterior = $this->pag > 1 ? ($this->pag-1) : 1;

            if($numPaginaAnterior > 1){

                // PÁGINA ANTERIOR 
                $pagination .=      "<li>";
                $pagination .=          "<a href='".$this->url.$numPaginaAnterior."' {$liPrev}>";
                $pagination .=              $liPrevSymbol;
                $pagination .=          '</a>';
                $pagination .=      "</li>";
            }

    	    //QUANTIDADE DE NUMERAÇÃO ANTES DO NÚMERO ATUAL, NÃO PERMITI SER MENOR QUE 1
    	    for($i=$this->pag - $this->maxLinks; $i<=$this->pag-1; $i++){
        		if($i>=1){

        			$pagination .=	"<li><a href='".$this->url.$i."'>".$i."</a></li>";
        		}
    	    }

    	    // PÁGINA ATIVA(ATUAL)
    	    $pagination .=	"<li class='ativo'><a href='".$this->url.$this->pag."'>".$this->pag."<span class='sr-only'>(current)</span></a></li>";
    		
    		//QUANTIDADE DE NUMERAÇÃO APÓS O NÚMERO ATUAL, NÃO PERMITINDO UM VALOR MAIOR QUE O TOTAL
    		for($i=$this->pag+1; $i<=$this->pag+$this->maxLinks; $i++){
        		if($i<$paginas){
        			$pagination .= "<li><a href='".$this->url.$i."'>".$i."</a></li>";
        		}
        	}

            //RECUPERA PÁGINA ANTERIOR
            $numProximaPagina = $this->pag < $paginas  ? ($this->pag+1) : $paginas;
            
            if($numProximaPagina < $paginas){
                //ÚLTIMA PÁGINA
                $pagination .=      "<li>";
                $pagination .=          "<a href='".$this->url.$numProximaPagina."' {$liNext}>";
                $pagination .=              $liNextSymbol;
                $pagination .=          "</a>";
                $pagination .=      "</li>";
            }

        	//ÚLTIMA PÁGINA
    		$pagination .=	    "<li>";
    		$pagination .=	      	"<a href='".$this->url.$paginas."' {$liNext}>";
    		$pagination .=	      		$liLastSymbol;
    		$pagination .=	 	 	"</a>";
    		$pagination .=		"</li>";
    	  	$pagination .= 	 "</ul>";
    		$pagination .= "</nav>";

    		echo $pagination;
        }
    }
}
