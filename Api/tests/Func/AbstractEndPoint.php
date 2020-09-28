<?php


namespace App\Tests\Func;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndPoint extends WebTestCase
{
    private $serverInformations = ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'];
    public function getResponseFromRequest($method, $uri, $payload = ''): Response
    {
        $client = self::createClient();

        $client->request(
            $method,
            $uri .'.json',
            [],
            [],
            $this->serverInformations,
            $payload

        );

        return $client->getResponse();
    }

}