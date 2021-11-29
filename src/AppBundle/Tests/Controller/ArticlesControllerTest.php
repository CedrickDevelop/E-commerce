<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticlesControllerTest extends WebTestCase
{
    public function testAjout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Ajout');
    }

}
