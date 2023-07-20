<?php

require 'vendor/autoload.php';

use Alura\BuscadorDeCurso\Buscador;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

//CRIANDO UM CLIENTE QUE PODERÁ FAZER TODAS AS REQUISIÇÕES NESSA URL BASE 
$client = new Client(['base_uri' => 'https://www.alura.com.br/', 'verify' => false]);

// CRAWLER SCRIPT QUE COLETA OS LINKS DO CODIGO FONTE 
$crawler = new Crawler();


$buscador = new Buscador($client,$crawler);
$cursos = $buscador ->buscar('cursos-online-programacao/php');

foreach ($cursos as $curso){
    echo exibir($curso);
}


?>