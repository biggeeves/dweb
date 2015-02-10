<?php

class VarSchemaTest extends TestCase {

    public function testVarSchema()
    {
        $crawler = $this->client->request('GET', '/var_schema/crf_a1demog/47');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('h2:contains("Variable Schema")'));
    }
}