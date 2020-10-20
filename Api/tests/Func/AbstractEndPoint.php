<?php


namespace App\Tests\Func;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndPoint extends WebTestCase
{
    protected $serverInformations = ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'];
    protected $tokenNotFound = 'JWT token not found';
    protected $notYourResource = 'It\'s not your resource';
    protected $loginPayload = '{"email": "%s", "password": "%s}';
    public function getResponseFromRequest(
        string $method,
        string $uri,
        string $payload = '',
        array $parameter = [],
        bool $withAuthentication = true
    ): Response {
        $client = $this->createAuthentificationClient($withAuthentication);

        $client->request(
            $method,
            $uri  . '.json',
            $parameter,
            [],
            $this->serverInformations,
            $payload
        );

        return $client->getResponse();
    }

    protected function createAuthentificationClient(bool $withAuthentification): kernelBrowser
    {
        $client = static::createClient();

        if (!$withAuthentification) {
            return $client;
        }
        $client->request(
            Request::METHOD_POST,
            '/api/login_check',
            [],
            [],
            $this->serverInformations,
            sprintf($this->loginPayload, AppFixture::DEFAULT_USER['email'], AppFixtures::DEFAULT_USER['password'])
        );
        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
        return $client;
    }
}
