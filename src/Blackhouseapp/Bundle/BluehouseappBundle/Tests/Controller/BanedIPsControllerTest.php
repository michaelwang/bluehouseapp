<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BanedIPsControllerTest extends WebTestCase
{

    public function testLoginScenario()
    {
        $client = static::createClient();
        
        // Create a new entry in the database
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /login/");
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => 'michael',
            '_password'  => '111111',          
        ));

        $client->submit($form);
        $crawler = $client->followRedirect(true);
        $this->assertTrue(
            $client->getResponse()->isRedirect()
        );
        $crawler = $client->request('GET', '/admin/banedips/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/banedips");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        $form = $crawler->selectButton('Create')->form(array(
          'blackhouseapp_bundle_bluehouseappbundle_banedips[ip]'  => '12.23.45.66',
          'blackhouseapp_bundle_bluehouseappbundle_banedips[fromDate][date][year]'  => '2015',
          'blackhouseapp_bundle_bluehouseappbundle_banedips[fromDate][date][month]'  => '12',
          'blackhouseapp_bundle_bluehouseappbundle_banedips[fromDate][date][day]' => '21',
          'blackhouseapp_bundle_bluehouseappbundle_banedips[toDate][date][year]' => '2017',
          'blackhouseapp_bundle_bluehouseappbundle_banedips[toDate][date][month]' => '1',
          'blackhouseapp_bundle_bluehouseappbundle_banedips[toDate][date][day]' => '12' ,               )); 
        $client->submit($form);
        $crawler = $client->followRedirect(true);
        $this->assertGreaterThan(0, $crawler->filter('td:contains("12.23.45.66")')->count(), 'Missing element td:contains("12.23.45.66")');        
    }
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/login/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /login/");
        
        // Fill in the form and submit it
        $form = $crawler->selectButton('Login')->form(array(
            'blackhouseapp_bundle_bluehouseappbundle_banedips[field_name]'  => 'Test',
            'blackhouseapp_bundle_bluehouseappbundle_banedips[field_name]'  => 'Test',          
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
/*
        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'blackhouseapp_bundle_bluehouseappbundle_banedips[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent()); 
    } */


}
