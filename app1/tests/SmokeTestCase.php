<?php

declare(strict_types=1);

namespace App\Tests;

use http\Exception\RuntimeException;
use LogicException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Router;

class SmokeTestCase extends WebTestCase
{
    private const POST_HTTP_METHOD = 'POST';

    protected KernelBrowser $client;
    private Router $router;

    /**
     * @throws LogicException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
        try {
            $this->router = $this->client->getContainer()->get('router');
        } catch (ServiceNotFoundException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @param array<string, mixed> $parameters
     * @throws InvalidParameterException
     * @throws MissingMandatoryParametersException
     * @throws RouteNotFoundException
     */
    protected function sendPostRequest(string $routeName, array $parameters): void
    {
        $uri = $this->router->generate($routeName);
        $this->client->request(
            method    : self::POST_HTTP_METHOD,
            uri       : $uri,
            parameters: $parameters,
        );
    }
}
