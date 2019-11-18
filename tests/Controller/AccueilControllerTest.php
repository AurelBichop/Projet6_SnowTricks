<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccueilControllerTest extends WebTestCase{

    /**
     * Permet de tester la route de l'accueil
     */
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Permet de tester la route pour le load more de l'accueil
     */
    public function testLoadMore()
    {
        $client = static::createClient();

        $client->request('GET', '/accueil/more');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}