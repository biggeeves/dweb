<?php

class CrfTest extends TestCase {

    public function testCrf()
    {
        // set up test data
        $allTables = DB::select('SHOW TABLES');
        if (isset($allTables)) {
            foreach ($allTables as $tablename) {
                foreach($tablename as $key=>$value) {
                    if( substr( $value, 0, 3)  == 'crf') {
                        if(DB::table( $value)->count() > 0) {
                            $firstTable = $value;
                            break;
                        }
                    }
                }
                if(isset($firstTable) ) break;
            }
        }           
        $checkTable = "/forms/$firstTable";
        $crawler = $this->client->request('GET', $checkTable);
        $this->assertTrue($this->client->getResponse()->isOk());
        
        // tests below do not work yet
        // Test for no data
        // $this->assertCount(1, $crawler->filter('div:contains("nothing was found")'));
        
        
        // test for data
        $this->assertCount(1, $crawler->filter('h2:contains("Generic Table")'));
    }
}