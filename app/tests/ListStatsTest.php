<?php

class ListStatsTest extends TestCase {

    public function testListStats()
    {
        $crawler = $this->client->request('GET', '/liststats');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("List Stats")'));
    }
}