<?php

class CrfTest extends TestCase {

    public function testCrf()
    {
        $crawler = $this->client->request('GET', '/forms/crf_contacts');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("crf_contacts")'));
    }
}