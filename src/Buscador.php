<?php

namespace Alura\BuscadorDeCursos;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador {

    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler ) {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function getCursosFromUrl(string $url) : array {
        $resposta = $this->httpClient->request("GET", $url);

        $html = $resposta->getBody();
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $elementos) {
            $cursos[] =$elementos->textContent;
        }
        return $cursos;
    }
}