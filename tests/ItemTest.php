<?php


class ItemTest extends TestCase
{
    /**
     * /items [GET]
     */
    public function testShouldReturnAllItems(){

        $this->get("items", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' =>
                [
                    'content',
                    'status',
                ]
        ]);

    }

    /**
     * /items [GET]
     */
    public function testShouldReturnStartingDownloadStatus(){

        $this->get("start-import", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status'
        ]);

    }
}
