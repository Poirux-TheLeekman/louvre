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

    /*public function testAddNewCommand()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Add To Cart')->form();

        $form['reservation[bookingDate]'] = '2028-08-08';
        $form['reservation[visitType]'] = 'fullDay';
        $form['reservation[email]'] = 'john.doe@mail.com';
        $form['reservation[tickets][0][guest][firstName]'] = 'john';
        $form['reservation[tickets][0][guest][lastName]'] = 'Doe';
        $form['reservation[tickets][0][guest][dateOfBirth]'] = '01/01/1950';
        $form['reservation[tickets][0][guest][country]'] = 'FR';
        $form['reservation[tickets][0][reducedPrice]'] = 1;
        
        $client->submit($form);
    }*/
    
}
