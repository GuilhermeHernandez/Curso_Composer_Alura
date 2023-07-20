<?php

namespace Alura\BuscadorDeCurso;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private ClientInterface $httpClient;
    private Crawler $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this ->httpClient = $httpClient;
        $this ->crawler = $crawler;
    }

    // PARA BUSCAR , PRECISAMOS DE UM CLIENTE QUE FAÇA UM REQUISIÇÃO E RETORNE COMO RESPOSTA O CODIGO ;
    // A CLASSE BUSCADOR JA CONTEM COMO ATRIBUTO UMA INTERFACE DE CLIENTE (ClienteInterface)
    //UM CRAWLER QUE É A LEITURA DA RESPOSTA
    public function buscar(string $url): array
    {
        // A RESPOSTA DE REQUISIÇÃO DA PAGINA INFORMADA
        $resposta = $this -> httpClient -> request('GET', $url);

        // O CORPO DO CONTEUDO TODO , QUERO RETORNA NA VARIAVEL HTML
        $html = $resposta ->getBody();

        //AGORA NO OBJETO CRAWLER ACIONAMOS O METODO
        //AddHtmlContent , QUE RECEBE UM CONTEUDO HTML E LIMPA ELE
        $this -> crawler ->addHtmlContent($html);

        // USANDO A INSTANCIA DE CRAWLER , USAMOS O METODO filter()
        // QUE FILTRA ALGUM ELEMENTO DO HTML RETORNADO NA VARIAVEL $elementosCursos
        // SENDO ASSIM ESSE ELEMENTE TER DIVERSOS OUTRAS INFORMAÇÕES
        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $curso) {
            //PEGANDO SOMENTE O TEXTO DO ELEMENTO
            $cursos[] = $curso ->textContent;
        }

        return $cursos;
    }
}
