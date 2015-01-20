<?php

class LogInTest extends TestCase {

    public function testLogIn()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("log in")'));
    }
}