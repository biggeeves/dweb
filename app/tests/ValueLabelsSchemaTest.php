<?php

class ValueLabelsSchemaTest extends TestCase {

    public function testValueLabelsSchema()
    {
        $crawler = $this->client->request('GET', '/value_schema/crf_a1demog/inmds');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("Value Labels")'));
    }
}