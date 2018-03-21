<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LouvreControllerTest extends WebTestCase
{
    public function testhomeAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        
        $this->assertContains('Bienvenue sur la plateforme billeterie du Musée du Louvre', $client->getResponse()->getContent());
        $this->assertContains('Je commande', $client->getResponse()->getContent());
    }

    public function testCreateForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/command/new');
                        
        $this->assertSame(1, $crawler->filter('html:contains("Nouvelle commande")')->count());
        $this->assertSame(1, $crawler->filter('input[type=email]')->count());
        $this->assertSame(1, $crawler->filter('input[type=text]')->count());
        $this->assertSame(1, $crawler->filter('input[type=checkbox]')->count());
        $this->assertEquals(5, $crawler->filter('div.form-group')->count());
  
    }

    
}
