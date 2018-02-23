<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LouvreControllerTest extends WebTestCase
{
    public function testhomeAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Bienvenue sur la plateforme billeterie du Musée du Louvre', $client->getResponse()->getContent());
        $this->assertContains('je commande', $client->getResponse()->getContent());
    }

    public function testaddAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/command/new');
                        
        $this->assertSame(1, $crawler->filter('html:contains("Nouvelle commande")')->count());
        $this->assertSame(1, $crawler->filter('input[type=email]')->count());
        $this->assertSame(1, $crawler->filter('input[type=text]')->count());
        //$this->assertSame(1, $crawler->filter('input[type=reset]')->count());
        //$this->assertSame(1, $crawler->filter('a#add_tag_link')->count());
        
    }

    /*public function testChargeAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/command/charge');
                        
        $this->assertSame(1, $crawler->filter('html:contains("Nouvelle commande")')->count());
        $this->assertSame(1, $crawler->filter('input[type=email]')->count());
        $this->assertSame(1, $crawler->filter('input[type=text]')->count());
        //$this->assertSame(1, $crawler->filter('input[type=reset]')->count());
        //$this->assertSame(1, $crawler->filter('a#add_tag_link')->count());
        
    }*/
}
