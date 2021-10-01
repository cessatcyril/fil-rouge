<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RechercheTest extends WebTestCase
{
    //test fonctionnel
    public function testRecherche3(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/recherche');

        $buttonCrawlerNode = $crawler->selectButton('rechercher');
        $form = $buttonCrawlerNode->form();
        $form['recherche'] = 'b';

        $crawler = $client->submit($form);

        $btn = $crawler->selectButton('next');

        $client->clickLink("next");

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.content>h1', 'Résultat de la recherche :');
    }
    //test un POST sans résultat 
    public function testRecherche4(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/recherche');

        $buttonCrawlerNode = $crawler->selectButton('rechercher');
        $form = $buttonCrawlerNode->form();
        $form['recherche'] = 'gsfgsv';
        $crawler = $client->submit($form);



        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.content>h1', 'Aucun résultat trouvé.');
    }
    //test avec un post vide
    public function testRecherche1(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/recherche');

        $buttonCrawlerNode = $crawler->selectButton('rechercher');
        $form = $buttonCrawlerNode->form();
        $form['recherche'] = '';
        $crawler = $client->submit($form);


        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.content>h1', 'Aucun résultat trouvé.');
    }
}
