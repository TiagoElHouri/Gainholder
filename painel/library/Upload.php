<?php

/* CLASSE DE UPLOAD PARA IMAGENS */

class Upload {

    private $arquivo;
    private $altura;
    private $largura;
    private $pasta;
    private $nomeFoto;

    function __construct($arquivo, $altura, $largura, $nomeFoto, $pasta) {
        $this->arquivo  = $arquivo;
        $this->altura   = $altura;
        $this->largura  = $largura;
        $this->nomeFoto = $nomeFoto;
        $this->pasta    = $pasta;
    }

    private function getExtensao() { //RETORNA A EXTENSÃO DA IMAGEM
        return $extensao = @strtolower(end(explode('.', $this->arquivo['name'])));
    }

    private function ehImagem($extensao) {
        $extensoes = array('gif', 'jpeg', 'jpg', 'png');// EXTENSÕES PERMITIDAS
        
        if (in_array($extensao, $extensoes)){
        	return true;
        }	
    }

    //LARGURA, ALTURA, TIPO, LOCALIZAÇÃO DA IMAGEM ORIGINAL
    private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao) {

        //DESCOBRIR NOVO TAMANHO , SEM PERDER A PROPORÇÃO
        if ($imgLarg > $imgAlt) {

            $novaLarg = $this->largura;
            $novaAlt  = round(($novaLarg / $imgLarg) * $imgAlt);
        } elseif ($imgAlt > $imgLarg) {

            $novaAlt  = $this->altura;
            $novaLarg = round(($novaAlt / $imgAlt) * $imgLarg);
        } else

        // ALTURA == LAARGURA 
        $novaAltura = $novaLargura = max($this->largura, $this->altura); //REDIMENCIONAR A IMAGEM
        
        //CRIA UMA NOVA IMAGEM , COM UM NOVO TAMANHO 
        @$novaimagem = imagecreatetruecolor($novaLarg, $novaAlt);

        switch ($tipo) {

            case 1: // gif 
                $origem = imagecreatefromgif($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagegif($novaimagem, $img_localizacao);
            break;

            case 2: // jpg 
                $origem = imagecreatefromjpeg($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagejpeg($novaimagem, $img_localizacao);
            break;

            case 3: // png 
                $origem = imagecreatefrompng($img_localizacao);
                @imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0, $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                @imagepng($novaimagem, $img_localizacao);
            break;
        }

        //DESTROI AS IMAGENS CRIADAS
        @imagedestroy($novaimagem);
        imagedestroy($origem);
    }

    public function salvar() {
        $extensao = $this->getExtensao();
        //GERA UM NOME UNICO PARA A IMAGEM EM FUNCAO DO TEMPO
        $novo_nome = $this->nomeFoto . '.' . $extensao;
        //LOCALIZAÇÃO DO ARQUIVO
        $destino = $this->pasta . $novo_nome;
        //MOVE O ARQUIVO
        if (!move_uploaded_file($this->arquivo['tmp_name'], $destino)) {

            if ($this->arquivo['error'] == 1)
                return "Tamanho excede o permitido";
            else
                return "Erro " . $this->arquivo['error'];
        }

        if ($this->ehImagem($extensao)) {
            //PEGA A LARGURA, ALTURA, TIPO E ATRIBUTO DA IMAGEM 
            list($largura, $altura, $tipo, $atributo) = getimagesize($destino);
            // TESTA SE É PRECISO REDIMENSIONAR A IMAGEM
            if (($largura > $this->largura) || ($altura > $this->altura))
                $this->redimensionar($largura, $altura, $tipo, $destino);
        }

        return true;
    }

}
