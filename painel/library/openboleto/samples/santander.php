<?php

require '../autoloader.php';

use OpenBoleto\Banco\Santander;
use OpenBoleto\Agente;

$sacado = new Agente('Fernando Azanha Rocha Matos', '398.523.798-01', 'Rua Luiz Tramontin 1977', '81230-161', 'Cuiritba', 'PR');
$cedente = new Agente('BINARY PIXEL DIGITAL LTDA.', '14.079.965/0001-26', 'Rua Brigadeiro Franco 3834', '80220-100', 'Curitiba', 'PR');

$boleto = new Santander(array(
    // Parâmetros obrigatórios
    'dataVencimento' => new DateTime('2014-11-13'),
    'valor' => 50698.15,
    'sequencial' => 0000000000001, // Até 13 dígitos
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => 4403, // Até 4 dígitos
    'carteira' => 102, // 101, 102 ou 201
    'conta' => 6834159, // Código do cedente: Até 7 dígitos
    'ios' => '0', // Apenas para o Santander

    // Parâmetros recomendáveis
    //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
    //'contaDv' => 5,
    'agenciaDv' => 2,
    'descricaoDemonstrativo' => array( // Até 5
        'Hospedagem de site'
    ),
    'instrucoes' => array( // Até 8
        //'Após o dia 30/11 cobrar 2% de mora e 1% de juros ao dia.',
        //'Não receber após o vencimento.',
    ),

    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    //'moeda' => Santander::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    //'especieDoc' => 'ABC',
    //'numeroDocumento' => '123.456.789',
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
