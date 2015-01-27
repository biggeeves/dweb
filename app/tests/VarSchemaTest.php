<?php

class VarSchemaTest extends TestCase {

    public function testVarSchema()
    {
        $crawler = $this->client->request('GET', '/crf_schema/crf_a1demog');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("Generic Table Schema View")'));
    }
}