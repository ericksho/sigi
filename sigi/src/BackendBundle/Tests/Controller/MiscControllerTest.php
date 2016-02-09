<?php

namespace BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MiscControllerTest extends WebTestCase
{
    public function testListoportunities()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listOportunities');
    }

}
