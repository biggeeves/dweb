<?php

class ValueSchemaTest extends TestCase {

    public function testValueSchema()
    {
        $crawler = $this->client->request('GET', '/value_schema/crf_a1demog/43');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("Variable Schema")'));
    }
}