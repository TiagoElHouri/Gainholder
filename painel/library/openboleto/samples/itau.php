<?php

require '../autoloader.php';

use OpenBoleto\Banco\Itau;
use OpenBoleto\Agente;

$sacado = new Agente('BINARY PIXEL DIGITAL LTDA ME', '14.079.965-001-26', '', '', '', '');
$cedente = new Agente('Rhlink Tecnologia Ltda ME', '17.622.766/0001-00', '', '', 'São Paulo', 'SP');

$boleto = new Itau(array(
    // Parâmetros obrigatórios
    'dataVencimento' => new DateTime('2014-09-23'),
    'valor' => 1.00,
    'sequencial' => 00000001, // 8 dígitos
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => 4073, // 4 dígitos
    'carteira' => 175, // 3 dígitos
    'conta' => 14829, // 5 dígitos
    
    // Parâmetro obrigatório somente se a carteira for
    // 107, 122, 142, 143, 196 ou 198
    //'codigoCliente' => 12345, // 5 dígitos
    //'numeroDocumento' => 1234567, // 7 dígitos

    // Parâmetros recomendáveis
    //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
    'contaDv' => 0,
    //'agenciaDv' => 1,
    'descricaoDemonstrativo' => array( // Até 5
        'Serviço de consulta',
    ),
    'instrucoes' => array( // Até 8
        'Não receber após o vencimento.'
    ),

    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    //'moeda' => Itau::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    //'especieDoc' => 'ABC',
    //'usoBanco' => 'Uso banco',
    //'layout' => 'layout.phtml',
    //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
    //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
    //'descontosAbatimentos' => 123.12,
    //'moraMulta' => 123.12,
    //'outrasDeducoes' => 123.12,
    //'outrosAcrescimos' => 123.12,
    //'valorCobrado' => 123.12,
    //'valorUnitario' => 123.12,
    //'quantidade' => 1,
));

echo $boleto->getOutput();
