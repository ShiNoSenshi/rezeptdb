<?php

namespace App\Tests\Functional;

class RestTestControllerTest extends AbstractWebTestCase
{

    public function testGetTest()
    {
        $this->clientAnon->request('GET', '/api/test');
        $this->assertEquals(200, $this->clientAnon->getResponse()->getStatusCode());

        $response = $this->clientAnon->getResponse()->getContent();
        self::assertEquals('"service available"', $response);
    }

    public function testGetLogin()
    {
        $this->client->request('GET', '/api/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $response = $this->client->getResponse()->getContent();
        self::assertEquals('"login successful"', $response);
    }

}
