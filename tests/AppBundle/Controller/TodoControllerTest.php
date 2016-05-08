<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoControllerTest extends WebTestCase
{
    public function testTodosIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/todos');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Task List', $crawler->filter('h2')->text());
    }

    public function testCreateAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/todo/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Add Task', $crawler->filter('h2')->text());
    }
}
