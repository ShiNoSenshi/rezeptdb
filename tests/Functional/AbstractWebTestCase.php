<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractWebTestCase extends WebTestCase
{
    /** @var Client */
    public $client;

    /** @var Client */
    public $clientAnon;

    public function setUp()
    {
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'supersecurepassword!',
        ));
        $this->client->catchExceptions(false);

        $this->clientAnon = static::createClient();
        $this->clientAnon->catchExceptions(false);
    }

    public function assertResponseContains(string $string): void
    {
        self::assertContains($string, $this->client->getResponse()->getContent());
    }

    public function assertSuccessMessage(string $string): void
    {
        self::assertContains($string, $this->client->getCrawler()->filter('.ui.positive.message')->text());
    }

    public function assertWarningMessage(string $string): void
    {
        self::assertContains($string, $this->client->getCrawler()->filter('.ui.warning.message')->text());
    }

    public function assertErrorMessage(string $string): void
    {
        self::assertContains($string, $this->client->getCrawler()->filter('.ui.negative.message')->text());
    }


}
