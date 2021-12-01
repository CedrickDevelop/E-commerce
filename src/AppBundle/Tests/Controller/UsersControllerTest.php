<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
    public function testInscription()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/inscription');
    }

    public function testConnexion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/connexion');
    }

}
