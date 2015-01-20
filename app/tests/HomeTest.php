<?php

class Home_test extends TestCase {

    public function testHomePage()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h1:contains("You have arrived")'));
    }
}