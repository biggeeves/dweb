<?php

class PrimaryKeysTest extends TestCase {

    public function testPrimaryKeys()
    {
        $crawler = $this->client->request('GET', '/primary_keys');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("Primary Keys")'));
    }
}