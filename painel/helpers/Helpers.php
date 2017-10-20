<?php

    /*

      FUNÇÕES GENÉRICAS QUE PODFEM SER USADAS MAIS DE UMA VEZ
      @author Palupa

     */

    /* * **** FUNÇÕES GENÉRICAS ***** /

      /**
     * SEPARA OS VALORES DAS COLUNAS PARA RETORNAR EM UM 'SQL'
     * @return array 
     */
    function fieldColumnSeparator(array $date) {

        if (is_array($date)) {

            $fields = array_keys($date);
            $values = array_values($date);

            $field = implode(",", $fields);
            $value = "'" . implode("','", $values) . "'";

            $result['fields'] = $field;
            $result['values'] = $value;
        }else{

            $result['erro'] = null;
        }

        return $result;
    }

    /**
     * GERA DINÂMICAMENTE OS CAMPOS PARA EDIÇÃO
     * @return string   
     */
    function updateSeparator(array $date) {

        if (is_array($date)) {

            $fields = array_keys($date);
            $values = array_values($date);
            $search = array();

            for ($i = 0; $i < count($fields); $i++) {

                if ($values[$i] != "") {

                    array_push($search, $fields[$i] . " = '" . $values[$i] . "'");
                }
            }

            $query['result'] = implode(", ", $search);
        }else{

            $query['result'] = null;
        }

        return $query;
    }

    /**
     * EXIBE UMA MENSAGEM FORMATADA DE ACORDO COM UMA AÇÃO
     * @return string   
     */
    function logs($message, $class) {

        if (is_string($message) && is_string($class)) {
            
             $messageLog = '      
                            <div class="alert '.$class.' alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                '.$message.'
                            </div>';
           
        }else{

            $messageLog = '      
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong>Alerta!</strong>
                            Mensagem indisponível
                        </div>';
        }

        return $messageLog;
    }

    /**
     * EXIBE UMA LABEL ADEQUADA AO STATUS
     * @return string   
     */
    function showStatus($nivel) {

        switch ($nivel) {

            case '1':

                $result = '<b style="color: green;">Liberado</b>';

            break;

            case '0':

                $result = '<b style="color: red;">Bloqueado</b>';

            break;

            default:

                $result = '<b style="color: red;">Bloqueado</b>';

            break;
        }

        return $result;
    }


    /**
     * VALIDA SE O DADO POSSUI SERIALIZAÇÃO
     * @return boolean
     */
    function is_serialized($value, &$result = null) {

        if ($value != null && $value != "") {
            
            // Bit of a give away this one
            if (!is_string($value)) {
                return false;
            }

            // Serialized false, return true. unserialize() returns false on an
            // invalid string or it could return false if the string is serialized
            // false, eliminate that possibility.
            if ($value === 'b:0;') {
                $result = false;
                return true;
            }

            $length = strlen($value);
            $end = '';

            switch ($value[0]) {
                case 's':
                    if ($value[$length - 2] !== '"') {
                        return false;
                    }
                case 'b':
                case 'i':
                case 'd':
                    // This looks odd but it is quicker than isset()ing
                    $end .= ';';
                case 'a':
                case 'O':
                    $end .= '}';

                    if ($value[1] !== ':') {
                        return false;
                    }

                    switch ($value[2]) {
                        case 0:
                        case 1:
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                        case 7:
                        case 8:
                        case 9:
                            break;

                        default:
                            return false;
                    }
                case 'N':
                    $end .= ';';

                    if ($value[$length - 1] !== $end[0]) {
                        return false;
                    }
                    break;

                default:
                    return false;
            }

            if (($result = @unserialize($value)) === false) {
                $result = null;
                return false;
            }
            return true;
        } else {
            return false;
        }

    }

    /**
    * REDIRECIONA PARA A URL PASSADA
    *
    */
    function redirect($url){

        echo "<script> window.location.href='".$url."' </script>";
    }

    /**
    * CONVERTE UM OBJETO EM UM ARRAY
    */
    function objectToArray($object,$module){

        $result = (array) $object;

        foreach($result as $key => $val){

            $new_array[trim(str_replace($module,'',$key))] = $val;
        } 

        return $new_array;
    }

    /**
    * DESABILITA CAMPOS INPUT
    */
    function disableField($array, $indice,$status = false){

        if(!$status){

            if(is_array($array) && $indice != null){

                if(isset($array[$indice])){

                    $fields = "disabled checked";
                }else{

                    $fields = "";
                }
            }else{

                $fields = "";
            }
        }else{

            if(is_array($array) && $indice != null){

                if(in_array($indice,$array)){

                    $fields = "disabled checked";
                }else{

                    $fields = "";
                }
            }else{

                $fields = "";
            }
        }

        return $fields;
    }

    /**
    * GERA LINHAS PARA UMA TABELA DE FORMA DINÂMICA DE ACORDO COM O RESULTADO PASSADO
    */
    function makeListReports($report,$fields){

        $table = "";
        $resultList  = null;
        if(count($report) > 0){

            for($i=0; $i<count($report); $i++):

                $table .= "<tr>";

                for($j=0; $j<count($fields); $j++){

                    $table .= "<td>". $report[$i][$fields[$j]] ."</td>";
                }

                $table .= "</tr>";
            endfor;
        }

        return $table; 
    }

    //  GERA DATAS DINÂMICAMENTE DE ACORDO COM O PERÍODO PASSADO
    function gerarDataPeriodo($data, $intervalo, $intervalos = array(), $periodo="mes"){
    
        $arrayIntervalos = array('dia' => 'days', 'mes' => 'months', 'ano' => 'years');
        
        if(!empty($data) && !empty($intervalo) && count($intervalos) > 0 && isset($arrayIntervalos[$periodo])){
            
            if(in_array($intervalo, $intervalos)){
                
                for($i=0; $i<count($intervalos); $i++){
                  
                  if($intervalos[$i] == $intervalo){
                    $resultadoData = date('Y-m-d', strtotime(' +'.$intervalos[$i].' '.$arrayIntervalos[$periodo], strtotime($data)));
                    break;
                  }
                }

            }else{
              $resultadoData = "Período não encontrado.";
            }

        }else{
          $resultadoData = "Dados inválidos para realizar essa ação.";
        }

        return $resultadoData;
    }    

    /**
    * VERIFICA SE PARA DETERMINADO CAMPO FORNECIDO HÁ IMAGEM CADASTRADA, SE NÃO
    * SERÁ COLOCADA A IMAGEM DEFAULT PARA FALTA DE CADASTRO DE IMAGENS.
    */
    function verifyImage($imagePath,$arrayEstImg){

        if($arrayEstImg == '' || (is_array($arrayEstImg) && empty($arrayEstImg))){

           $srcWithoutImage = 'semImagem.jpg' ;
           $result = $srcWithoutImage;       
        }else{

           $result = $arrayEstImg;
        }

        return $result;
    }

    /**
    * LIMITA A QUANTIDADE DE PALAVRAS EXIBIDAS EM UM TEXTO
    */
    function limitedWords($string, $limit=50){

        if(!empty($string)){

            $texto = mb_substr($string, 0, $limit)." ...";
        }else{

            $texto = "";
        }

        return $texto;
    }

    /**
    * RECUPERA AS COORDERNANDAS (LATITUDE E LONGITUDE) DE UM DETERMINADO ENDEREÇO
    */
    function getCoordinatesUrlAddress($address){

        $urlEncode = urlencode($address);
        $url = "https://maps.google.com/maps/api/geocode/json?address=".$urlEncode."&sensor=false&key=AIzaSyDb-qpSPzGhCDRBZZSiWoT8IX84Rsnsp60";

        //  INICIALIZANDO CURL
        $ch = curl_init();

        // DESABILITANDO VERIFICAÇÃO SSL 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // RETORNARÁ A RESPOSTA DA CONEXÃO SE FOR FALSO RETRONA A RESPOSTA 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // RECEBE A URL
        curl_setopt($ch, CURLOPT_URL,$url);

        // EXECUTA A BUSCA
        $result=curl_exec($ch);

        // DESCONECTA CURL
        curl_close($ch);

        //RECUPERA O RESULTADO PASSADO PELA API
        $result = file_get_contents($url);

        // DECODIFICA O JSON RETORNADO
        $resultAddress = json_decode($result, true);

        $latitude  = (($resultAddress['results'][0]['geometry']['location']['lat'] != null) ? $resultAddress['results'][0]['geometry']['location']['lat']  : null);
        $longitude = (($resultAddress['results'][0]['geometry']['location']['lng'] != null) ? $resultAddress['results'][0]['geometry']['location']['lng']  : null);
        
        $location = array('latitude' => $latitude, 'longitude' => $longitude);


        return $location;
    }

    /**
    * REALIZA O CALCULO DE DISTÂNCIA ENTRE DOIS PARES DE COORDENADAS, LEVANDO EM CONSIDERAÇÃO A CURVATURA DO GLOBO
    */
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper($unit);

        if($unit == "K") {

            $result = ($miles * 1.609344);
        }else if($unit == "N") {

            $result = ($miles * 0.8684); 
        }else{

            $result = $miles;
        }

        return $result;
    }

    /**
    * REMOVER ACENTO PARA TORNAR A URL AMIGÁVEL
    */
    function removeAccents($string, $slug = false) {

      $string = mb_strtolower($string);

      // Código ASCII das vogais
      $ascii['a'] = range(224, 230);
      $ascii['e'] = range(232, 235);
      $ascii['i'] = range(236, 239);
      $ascii['o'] = array_merge(range(242, 246), array(240, 248));
      $ascii['u'] = range(249, 252);

      // Código ASCII dos outros caracteres
      $ascii['b'] = array(223);
      $ascii['c'] = array(231);
      $ascii['d'] = array(208);
      $ascii['n'] = array(241);
      $ascii['y'] = array(253, 255);

      foreach ($ascii as $key=>$item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/['.$acentos.']/i';
      }

      $string = preg_replace(array_values($troca), array_keys($troca), $string);

      // Slug?
      if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
      }

      return $string;
    }

    /**
    * TRARA ERRO DE REQUISIÇÃO À ALGUMA URL COM UMA MENSAGEM APROPRIADA
    */
    function errorPage($erro="Ocorreu um erro na requisição"){

        $mensagem["erroMessage"] = $erro;
        extract($mensagem);
        include_once("views/erro/erro.php");
    }

    /**
    * UTILIZAÇÃO DE EXPRESSÕES REGULARES PARA E-MAILS VÁLIDOS
    */
    function checkEmail($email) {

        $conta    = "^[a-zA-Z0-9\._-]+@";
        $domino   = "[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$";
        $pattern  = $conta.$domino.$extensao;

        if (mb_ereg($pattern, $email)){

            $resultado = true;
        }else{

            $resultado = false;
        }

        return $resultado;
    }

    /**
    * ORDENAÇÃO DE VALORES EM UM ARRAY, EM ORDEM DECRESCENTE E CRESCENTE
    */
    function array_sort($array, $on, $order=SORT_ASC){

        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {

            foreach($array as $k => $v) {

                if(is_array($v)) {

                    foreach($v as $k2 => $v2) {

                        if($k2 == $on) {

                            $sortable_array[$k] = $v2;
                        }
                    }
                }else{

                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {

                case SORT_ASC:

                    asort($sortable_array);

                break;

                case SORT_DESC:

                    arsort($sortable_array);

                break;

            }

            foreach ($sortable_array as $k => $v) {

                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    /**
    * ADAPATAÇÃO PARA VALOR EM REAL
    */
    function formatReal($valor,$separador=""){

        if(!empty($valor)){

            $valorBruto = str_replace("R$", "", $valor);
            $valorReal  = str_replace(".","",$valorBruto);

            if(empty($separador)){

                if(strstr($valorReal, ',')){

                    $cortarValor = (strpos($valorReal, ',') - strlen($valorReal));
                    $valorReal   = substr($valorReal,0,$cortarValor); 
                }else{

                    $valorReal  = str_replace(",",$separador,$valorReal);
                }
            }else{

                $valorReal  = str_replace(",",$separador,$valorReal);
            }
        }else{

            $valorReal = "0";
        }

        return $valorReal;
    }

    /**
    * VALIDAÇÃO PARA O FORMATO CORRETO DE DATAS
    */
    function checkData($mesAtual, $diaAtual, $anoAtual){

        if(checkdate($mesAtual, $diaAtual, $anoAtual)){

            $mesAtual = $mesAtual < 10 ? "0".$mesAtual : $mesAtual;
            $dataPagamento = $anoAtual .'-'. $mesAtual;
        }else{

            if($mesAtual > 12){

                $mesAtual = 1;
                $anoAtual = ($anoAtual+1);
            }

            do {

                if(checkdate($mesAtual, $diaAtual, $anoAtual)){

                    $mesAtual = $mesAtual < 10 ? "0".$mesAtual : $mesAtual;

                    $dataPagamento = $anoAtual .'-'. $mesAtual;
                    $data          = true;
                }else{

                    $data = false;

                    if($diaAtual == 31){

                        $diaAtual = 1;
                    }else{

                        $diaAtual++;
                    }
                }

            } while ($data == false);
        }

        $diaAtual = strlen($diaAtual) == 1 ? str_pad($diaAtual,2,"0",STR_PAD_LEFT) : $diaAtual;
        $dataPagamento .= '-'.$diaAtual;

        return $dataPagamento;
    }

    /**
    * FUNÇÃO QUE EXIBE OS CÓDIGOS PARA O FONT AWESOME, ICONES LIDOS ATRAVÉS DE UMA HASH
    */
    function getFontAwesomeCodes(){

        return $FONT_A_CODES = array('fa-500px' => 'f26e','fa-adjust' => 'f042','fa-adn' => 'f170','fa-align-center' => 'f037','fa-align-justify' => 'f039',
                            'fa-align-left' => 'f036','fa-align-right' => 'f038','fa-amazon' => 'f270','fa-ambulance' => 'f0f9','fa-anchor' => 'f13d',
                            'fa-android' => 'f17b','fa-angellist' => 'f209','fa-angle-double-down' => 'f103','fa-angle-double-left' => 'f100',
                            'fa-angle-double-right' => 'f101','fa-angle-double-up' => 'f102','fa-angle-down' => 'f107','fa-angle-left' => 'f104',
                            'fa-angle-right' => 'f105','fa-angle-up' => 'f106','fa-apple' => 'f179','fa-archive' => 'f187','fa-area-chart' => 'f1fe',
                            'fa-arrow-circle-down' => 'f0ab','fa-arrow-circle-left' => 'f0a8','fa-arrow-circle-o-down' => 'f01a','fa-arrow-circle-o-left' => 'f190',
                            'fa-arrow-circle-o-right' => 'f18e','fa-arrow-circle-o-up' => 'f01b','fa-arrow-circle-right' => 'f0a9','fa-arrow-circle-up' => 'f0aa',
                            'fa-arrow-down' => 'f063','fa-arrow-left' => 'f060','fa-arrow-right' => 'f061','fa-arrow-up' => 'f062','fa-arrows' => 'f047',
                            'fa-arrows-alt' => 'f0b2','fa-arrows-h' => 'f07e','fa-arrows-v' => 'f07d','fa-asterisk' => 'f069','fa-at' => 'f1fa','fa-backward' => 'f04a',
                            'fa-balance-scale' => 'f24e','fa-ban' => 'f05e','fa-bar-chart' => 'f080','fa-barcode' => 'f02a','fa-bars' => 'f0c9',
                            'fa-battery-empty' => 'f244','fa-battery-full' => 'f240','fa-battery-half' => 'f242','fa-battery-quarter' => 'f243',
                            'fa-battery-three-quarters' => 'f241','fa-bed' => 'f236','fa-beer' => 'f0fc','fa-behance' => 'f1b4','fa-behance-square' => 'f1b5',
                            'fa-bell' => 'f0f3','fa-bell-o' => 'f0a2','fa-bell-slash' => 'f1f6','fa-bell-slash-o' => 'f1f7','fa-bicycle' => 'f206',
                            'fa-binoculars' => 'f1e5','fa-birthday-cake' => 'f1fd','fa-bitbucket' => 'f171','fa-bitbucket-square' => 'f172','fa-black-tie' => 'f27e',
                            'fa-bluetooth' => 'f293','fa-bluetooth-b' => 'f294','fa-bold' => 'f032','fa-bolt' => 'f0e7','fa-bomb' => 'f1e2','fa-book' => 'f02d',
                            'fa-bookmark' => 'f02e','fa-bookmark-o' => 'f097','fa-briefcase' => 'f0b1','fa-btc' => 'f15a','fa-bug' => 'f188','fa-building' => 'f1ad',
                            'fa-building-o' => 'f0f7','fa-bullhorn' => 'f0a1','fa-bullseye' => 'f140','fa-bus' => 'f207','fa-buysellads' => 'f20d',
                            'fa-calculator' => 'f1ec','fa-calendar' => 'f073','fa-calendar-check-o' => 'f274','fa-calendar-minus-o' => 'f272','fa-calendar-o' => 'f133',
                            'fa-calendar-plus-o' => 'f271','fa-calendar-times-o' => 'f273','fa-camera' => 'f030','fa-camera-retro' => 'f083','fa-car' => 'f1b9',
                            'fa-caret-down' => 'f0d7','fa-caret-left' => 'f0d9','fa-caret-right' => 'f0da','fa-caret-square-o-down' => 'f150',
                            'fa-caret-square-o-left' => 'f191','fa-caret-square-o-right' => 'f152','fa-caret-square-o-up' => 'f151','fa-caret-up' => 'f0d8',
                            'fa-cart-arrow-down' => 'f218','fa-cart-plus' => 'f217','fa-cc' => 'f20a','fa-cc-amex' => 'f1f3','fa-cc-diners-club' => 'f24c',
                            'fa-cc-discover' => 'f1f2','fa-cc-jcb' => 'f24b','fa-cc-mastercard' => 'f1f1','fa-cc-paypal' => 'f1f4','fa-cc-stripe' => 'f1f5',
                            'fa-cc-visa' => 'f1f0','fa-certificate' => 'f0a3','fa-chain-broken' => 'f127','fa-check' => 'f00c','fa-check-circle' => 'f058',
                            'fa-check-circle-o' => 'f05d','fa-check-square' => 'f14a','fa-check-square-o' => 'f046','fa-chevron-circle-down' => 'f13a',
                            'fa-chevron-circle-left' => 'f137','fa-chevron-circle-right' => 'f138','fa-chevron-circle-up' => 'f139','fa-chevron-down' => 'f078',
                            'fa-chevron-left' => 'f053','fa-chevron-right' => 'f054','fa-chevron-up' => 'f077','fa-child' => 'f1ae','fa-chrome' => 'f268',
                            'fa-circle' => 'f111','fa-circle-o' => 'f10c','fa-circle-o-notch' => 'f1ce','fa-circle-thin' => 'f1db','fa-clipboard' => 'f0ea',
                            'fa-clock-o' => 'f017','fa-clone' => 'f24d','fa-cloud' => 'f0c2','fa-cloud-download' => 'f0ed','fa-cloud-upload' => 'f0ee',
                            'fa-code' => 'f121','fa-code-fork' => 'f126','fa-codepen' => 'f1cb','fa-codiepie' => 'f284','fa-coffee' => 'f0f4','fa-cog' => 'f013',
                            'fa-cogs' => 'f085','fa-columns' => 'f0db','fa-comment' => 'f075','fa-comment-o' => 'f0e5','fa-commenting' => 'f27a',
                            'fa-commenting-o' => 'f27b','fa-comments' => 'f086','fa-comments-o' => 'f0e6','fa-compass' => 'f14e','fa-compress' => 'f066',
                            'fa-connectdevelop' => 'f20e','fa-contao' => 'f26d','fa-copyright' => 'f1f9','fa-creative-commons' => 'f25e','fa-credit-card' => 'f09d',
                            'fa-credit-card-alt' => 'f283','fa-crop' => 'f125','fa-crosshairs' => 'f05b','fa-css3' => 'f13c','fa-cube' => 'f1b2','fa-cubes' => 'f1b3',
                            'fa-cutlery' => 'f0f5','fa-dashcube' => 'f210','fa-database' => 'f1c0','fa-delicious' => 'f1a5','fa-desktop' => 'f108',
                            'fa-deviantart' => 'f1bd','fa-diamond' => 'f219','fa-digg' => 'f1a6','fa-dot-circle-o' => 'f192','fa-download' => 'f019',
                            'fa-dribbble' => 'f17d','fa-dropbox' => 'f16b','fa-drupal' => 'f1a9','fa-edge' => 'f282','fa-eject' => 'f052','fa-ellipsis-h' => 'f141',
                            'fa-ellipsis-v' => 'f142','fa-empire' => 'f1d1','fa-envelope' => 'f0e0','fa-envelope-o' => 'f003','fa-envelope-square' => 'f199',
                            'fa-eraser' => 'f12d','fa-eur' => 'f153','fa-exchange' => 'f0ec','fa-exclamation' => 'f12a','fa-exclamation-circle' => 'f06a',
                            'fa-exclamation-triangle' => 'f071','fa-expand' => 'f065','fa-expeditedssl' => 'f23e','fa-external-link' => 'f08e',
                            'fa-external-link-square' => 'f14c','fa-eye' => 'f06e','fa-eye-slash' => 'f070','fa-eyedropper' => 'f1fb','fa-facebook' => 'f09a',
                            'fa-facebook-official' => 'f230','fa-facebook-square' => 'f082','fa-fast-backward' => 'f049','fa-fast-forward' => 'f050','fa-fax' => 'f1ac',
                            'fa-female' => 'f182','fa-fighter-jet' => 'f0fb','fa-file' => 'f15b','fa-file-archive-o' => 'f1c6','fa-file-audio-o' => 'f1c7',
                            'fa-file-code-o' => 'f1c9','fa-file-excel-o' => 'f1c3','fa-file-image-o' => 'f1c5','fa-file-o' => 'f016','fa-file-pdf-o' => 'f1c1',
                            'fa-file-powerpoint-o' => 'f1c4','fa-file-text' => 'f15c','fa-file-text-o' => 'f0f6','fa-file-video-o' => 'f1c8','fa-file-word-o' => 'f1c2',
                            'fa-files-o' => 'f0c5','fa-film' => 'f008','fa-filter' => 'f0b0','fa-fire' => 'f06d','fa-fire-extinguisher' => 'f134','fa-firefox' => 'f269',
                            'fa-flag' => 'f024','fa-flag-checkered' => 'f11e','fa-flag-o' => 'f11d','fa-flask' => 'f0c3','fa-flickr' => 'f16e','fa-floppy-o' => 'f0c7',
                            'fa-folder' => 'f07b','fa-folder-o' => 'f114','fa-folder-open' => 'f07c','fa-folder-open-o' => 'f115','fa-font' => 'f031',
                            'fa-fonticons' => 'f280','fa-fort-awesome' => 'f286','fa-forumbee' => 'f211','fa-forward' => 'f04e','fa-foursquare' => 'f180',
                            'fa-frown-o' => 'f119','fa-futbol-o' => 'f1e3','fa-gamepad' => 'f11b','fa-gavel' => 'f0e3','fa-gbp' => 'f154','fa-genderless' => 'f22d',
                            'fa-get-pocket' => 'f265','fa-gg' => 'f260','fa-gg-circle' => 'f261','fa-gift' => 'f06b','fa-git' => 'f1d3','fa-git-square' => 'f1d2',
                            'fa-github' => 'f09b','fa-github-alt' => 'f113','fa-github-square' => 'f092','fa-glass' => 'f000','fa-globe' => 'f0ac','fa-google' => 'f1a0',
                            'fa-google-plus' => 'f0d5','fa-google-plus-square' => 'f0d4','fa-google-wallet' => 'f1ee','fa-graduation-cap' => 'f19d',
                            'fa-gratipay' => 'f184','fa-h-square' => 'f0fd','fa-hacker-news' => 'f1d4','fa-hand-lizard-o' => 'f258','fa-hand-o-down' => 'f0a7',
                            'fa-hand-o-left' => 'f0a5','fa-hand-o-right' => 'f0a4','fa-hand-o-up' => 'f0a6','fa-hand-paper-o' => 'f256','fa-hand-peace-o' => 'f25b',
                            'fa-hand-pointer-o' => 'f25a','fa-hand-rock-o' => 'f255','fa-hand-scissors-o' => 'f257','fa-hand-spock-o' => 'f259','fa-hashtag' => 'f292',
                            'fa-hdd-o' => 'f0a0','fa-header' => 'f1dc','fa-headphones' => 'f025','fa-heart' => 'f004','fa-heart-o' => 'f08a','fa-heartbeat' => 'f21e',
                            'fa-history' => 'f1da','fa-home' => 'f015','fa-hospital-o' => 'f0f8','fa-hourglass' => 'f254','fa-hourglass-end' => 'f253',
                            'fa-hourglass-half' => 'f252','fa-hourglass-o' => 'f250','fa-hourglass-start' => 'f251','fa-houzz' => 'f27c','fa-html5' => 'f13b',
                            'fa-i-cursor' => 'f246','fa-ils' => 'f20b','fa-inbox' => 'f01c','fa-indent' => 'f03c','fa-industry' => 'f275','fa-info' => 'f129',
                            'fa-info-circle' => 'f05a','fa-inr' => 'f156','fa-instagram' => 'f16d','fa-internet-explorer' => 'f26b','fa-ioxhost' => 'f208',
                            'fa-italic' => 'f033','fa-joomla' => 'f1aa','fa-jpy' => 'f157','fa-jsfiddle' => 'f1cc','fa-key' => 'f084','fa-keyboard-o' => 'f11c',
                            'fa-krw' => 'f159','fa-language' => 'f1ab','fa-laptop' => 'f109','fa-lastfm' => 'f202',
                            'fa-lastfm-square' => 'f203','fa-leaf' => 'f06c','fa-leanpub' => 'f212','fa-lemon-o' => 'f094','fa-level-down' => 'f149',
                            'fa-level-up' => 'f148','fa-life-ring' => 'f1cd','fa-lightbulb-o' => 'f0eb','fa-line-chart' => 'f201','fa-link' => 'f0c1',
                            'fa-linkedin' => 'f0e1','fa-linkedin-square' => 'f08c','fa-linux' => 'f17c','fa-list' => 'f03a','fa-list-alt' => 'f022',
                            'fa-list-ol' => 'f0cb','fa-list-ul' => 'f0ca','fa-location-arrow' => 'f124','fa-lock' => 'f023','fa-long-arrow-down' => 'f175',
                            'fa-long-arrow-left' => 'f177','fa-long-arrow-right' => 'f178','fa-long-arrow-up' => 'f176','fa-magic' => 'f0d0','fa-magnet' => 'f076',
                            'fa-male' => 'f183','fa-map' => 'f279','fa-map-marker' => 'f041','fa-map-o' => 'f278','fa-map-pin' => 'f276','fa-map-signs' => 'f277',
                            'fa-mars' => 'f222','fa-mars-double' => 'f227','fa-mars-stroke' => 'f229','fa-mars-stroke-h' => 'f22b','fa-mars-stroke-v' => 'f22a',
                            'fa-maxcdn' => 'f136','fa-meanpath' => 'f20c','fa-medium' => 'f23a','fa-medkit' => 'f0fa','fa-meh-o' => 'f11a','fa-mercury' => 'f223',
                            'fa-microphone' => 'f130','fa-microphone-slash' => 'f131','fa-minus' => 'f068','fa-minus-circle' => 'f056','fa-minus-square' => 'f146',
                            'fa-minus-square-o' => 'f147','fa-mixcloud' => 'f289','fa-mobile' => 'f10b','fa-modx' => 'f285','fa-money' => 'f0d6','fa-moon-o' => 'f186',
                            'fa-motorcycle' => 'f21c','fa-mouse-pointer' => 'f245','fa-music' => 'f001','fa-neuter' => 'f22c','fa-newspaper-o' => 'f1ea',
                            'fa-object-group' => 'f247','fa-object-ungroup' => 'f248','fa-odnoklassniki' => 'f263','fa-odnoklassniki-square' => 'f264',
                            'fa-opencart' => 'f23d','fa-openid' => 'f19b','fa-opera' => 'f26a','fa-optin-monster' => 'f23c','fa-outdent' => 'f03b',
                            'fa-pagelines' => 'f18c','fa-paint-brush' => 'f1fc','fa-paper-plane' => 'f1d8','fa-paper-plane-o' => 'f1d9','fa-paperclip' => 'f0c6',
                            'fa-paragraph' => 'f1dd','fa-pause' => 'f04c','fa-pause-circle' => 'f28b','fa-pause-circle-o' => 'f28c','fa-paw' => 'f1b0',
                            'fa-paypal' => 'f1ed','fa-pencil' => 'f040','fa-pencil-square' => 'f14b','fa-pencil-square-o' => 'f044','fa-percent' => 'f295',
                            'fa-phone' => 'f095','fa-phone-square' => 'f098','fa-picture-o' => 'f03e','fa-pie-chart' => 'f200','fa-pied-piper' => 'f1a7',
                            'fa-pied-piper-alt' => 'f1a8','fa-pinterest' => 'f0d2','fa-pinterest-p' => 'f231','fa-pinterest-square' => 'f0d3','fa-plane' => 'f072',
                            'fa-play' => 'f04b','fa-play-circle' => 'f144','fa-play-circle-o' => 'f01d','fa-plug' => 'f1e6','fa-plus' => 'f067',
                            'fa-plus-circle' => 'f055','fa-plus-square' => 'f0fe','fa-plus-square-o' => 'f196','fa-power-off' => 'f011','fa-print' => 'f02f',
                            'fa-product-hunt' => 'f288','fa-puzzle-piece' => 'f12e','fa-qq' => 'f1d6','fa-qrcode' => 'f029','fa-question' => 'f128',
                            'fa-question-circle' => 'f059','fa-quote-left' => 'f10d','fa-quote-right' => 'f10e','fa-random' => 'f074','fa-rebel' => 'f1d0',
                            'fa-recycle' => 'f1b8','fa-reddit' => 'f1a1','fa-reddit-alien' => 'f281','fa-reddit-square' => 'f1a2','fa-refresh' => 'f021',
                            'fa-registered' => 'f25d','fa-renren' => 'f18b','fa-repeat' => 'f01e','fa-reply' => 'f112','fa-reply-all' => 'f122','fa-retweet' => 'f079',
                            'fa-road' => 'f018','fa-rocket' => 'f135','fa-rss' => 'f09e','fa-rss-square' => 'f143','fa-rub' => 'f158','fa-safari' => 'f267',
                            'fa-scissors' => 'f0c4','fa-scribd' => 'f28a','fa-search' => 'f002','fa-search-minus' => 'f010','fa-search-plus' => 'f00e',
                            'fa-sellsy' => 'f213','fa-server' => 'f233','fa-share' => 'f064','fa-share-alt' => 'f1e0','fa-share-alt-square' => 'f1e1',
                            'fa-share-square' => 'f14d','fa-share-square-o' => 'f045','fa-shield' => 'f132','fa-ship' => 'f21a','fa-shirtsinbulk' => 'f214',
                            'fa-shopping-bag' => 'f290','fa-shopping-basket' => 'f291','fa-shopping-cart' => 'f07a','fa-sign-in' => 'f090','fa-sign-out' => 'f08b',
                            'fa-signal' => 'f012','fa-simplybuilt' => 'f215','fa-sitemap' => 'f0e8','fa-skyatlas' => 'f216','fa-skype' => 'f17e','fa-slack' => 'f198',
                            'fa-sliders' => 'f1de','fa-slideshare' => 'f1e7','fa-smile-o' => 'f118','fa-sort' => 'f0dc','fa-sort-alpha-asc' => 'f15d',
                            'fa-sort-alpha-desc' => 'f15e','fa-sort-amount-asc' => 'f160','fa-sort-amount-desc' => 'f161','fa-sort-asc' => 'f0de',
                            'fa-sort-desc' => 'f0dd','fa-sort-numeric-asc' => 'f162','fa-sort-numeric-desc' => 'f163','fa-soundcloud' => 'f1be',
                            'fa-space-shuttle' => 'f197','fa-spinner' => 'f110','fa-spoon' => 'f1b1','fa-spotify' => 'f1bc','fa-square' => 'f0c8',
                            'fa-square-o' => 'f096','fa-stack-exchange' => 'f18d','fa-stack-overflow' => 'f16c','fa-star' => 'f005','fa-star-half' => 'f089',
                            'fa-star-half-o' => 'f123','fa-star-o' => 'f006','fa-steam' => 'f1b6','fa-steam-square' => 'f1b7','fa-step-backward' => 'f048',
                            'fa-step-forward' => 'f051','fa-stethoscope' => 'f0f1','fa-sticky-note' => 'f249','fa-sticky-note-o' => 'f24a','fa-stop' => 'f04d',
                            'fa-stop-circle' => 'f28d','fa-stop-circle-o' => 'f28e','fa-street-view' => 'f21d','fa-strikethrough' => 'f0cc','fa-stumbleupon' => 'f1a4',
                            'fa-stumbleupon-circle' => 'f1a3','fa-subscript' => 'f12c','fa-subway' => 'f239','fa-suitcase' => 'f0f2','fa-sun-o' => 'f185',
                            'fa-superscript' => 'f12b','fa-table' => 'f0ce','fa-tablet' => 'f10a','fa-tachometer' => 'f0e4','fa-tag' => 'f02b','fa-tags' => 'f02c',
                            'fa-tasks' => 'f0ae','fa-taxi' => 'f1ba','fa-television' => 'f26c','fa-tencent-weibo' => 'f1d5','fa-terminal' => 'f120',
                            'fa-text-height' => 'f034','fa-text-width' => 'f035','fa-th' => 'f00a','fa-th-large' => 'f009','fa-th-list' => 'f00b',
                            'fa-thumb-tack' => 'f08d','fa-thumbs-down' => 'f165','fa-thumbs-o-down' => 'f088','fa-thumbs-o-up' => 'f087','fa-thumbs-up' => 'f164',
                            'fa-ticket' => 'f145','fa-times' => 'f00d','fa-times-circle' => 'f057','fa-times-circle-o' => 'f05c','fa-tint' => 'f043',
                            'fa-toggle-off' => 'f204','fa-toggle-on' => 'f205','fa-trademark' => 'f25c','fa-train' => 'f238','fa-transgender' => 'f224',
                            'fa-transgender-alt' => 'f225','fa-trash' => 'f1f8','fa-trash-o' => 'f014','fa-tree' => 'f1bb','fa-trello' => 'f181',
                            'fa-tripadvisor' => 'f262','fa-trophy' => 'f091','fa-truck' => 'f0d1','fa-try' => 'f195','fa-tty' => 'f1e4','fa-tumblr' => 'f173',
                            'fa-tumblr-square' => 'f174','fa-twitch' => 'f1e8','fa-twitter' => 'f099','fa-twitter-square' => 'f081','fa-umbrella' => 'f0e9',
                            'fa-underline' => 'f0cd','fa-undo' => 'f0e2','fa-university' => 'f19c','fa-unlock' => 'f09c','fa-unlock-alt' => 'f13e','fa-upload' => 'f093',
                            'fa-usb' => 'f287','fa-usd' => 'f155','fa-user' => 'f007','fa-user-md' => 'f0f0','fa-user-plus' => 'f234','fa-user-secret' => 'f21b',
                            'fa-user-times' => 'f235','fa-users' => 'f0c0','fa-venus' => 'f221','fa-venus-double' => 'f226','fa-venus-mars' => 'f228',
                            'fa-viacoin' => 'f237','fa-video-camera' => 'f03d','fa-vimeo' => 'f27d','fa-vimeo-square' => 'f194','fa-vine' => 'f1ca','fa-vk' => 'f189',
                            'fa-volume-down' => 'f027','fa-volume-off' => 'f026','fa-volume-up' => 'f028','fa-weibo' => 'f18a','fa-weixin' => 'f1d7',
                            'fa-whatsapp' => 'f232','fa-wheelchair' => 'f193','fa-wifi' => 'f1eb','fa-wikipedia-w' => 'f266','fa-windows' => 'f17a',
                            'fa-wordpress' => 'f19a','fa-wrench' => 'f0ad','fa-xing' => 'f168','fa-xing-square' => 'f169','fa-y-combinator' => 'f23b',
                            'fa-yahoo' => 'f19e','fa-yelp' => 'f1e9','fa-youtube' => 'f167','fa-youtube-play' => 'f16a','fa-youtube-square' => 'f166');
    }

?> 