<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Router;

class SmokeTestCase extends WebTestCase
{
    private const POST_HTTP_METHOD = 'POST';

    private const GET_HTTP_METHOD = 'GET';

    private const PATCH_HTTP_METHOD = 'PATCH';

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

        $this->beginTransaction();
    }

    private function beginTransaction(): void
    {
        $this->getEntityManager()->beginTransaction();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::getContainer()->get(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }

    private function rollbackTransaction(): void
    {
        $this->getEntityManager()->rollback();
    }

    /**
     * @param array<string, mixed> $parameters
     * @throws InvalidParameterException
     * @throws MissingMandatoryParametersException
     * @throws RouteNotFoundException
     */
    protected function sendPostRequestWithResponse(string $routeName, array $parameters): Response
    {
        $uri = $this->router->generate($routeName);
        $this->client->request(
            method    : self::POST_HTTP_METHOD,
            uri       : $uri,
            parameters: $parameters,
        );

        /** @var Response */
        return $this->client->getResponse();
    }

    /**
     * @param array<string, mixed> $queryParameters
     * @param array<string, mixed> $requestParameters
     * @throws InvalidParameterException
     * @throws MissingMandatoryParametersException
     * @throws RouteNotFoundException
     */
    protected function sendPatchRequestWithResponse(
        string $routeName,
        array $queryParameters,
        array $requestParameters
    ): Response {
        $uri = $this->router->generate($routeName, $queryParameters);
        $this->client->request(
            method    : self::PATCH_HTTP_METHOD,
            uri       : $uri,
            parameters: $requestParameters,
        );

        /** @var Response */
        return $this->client->getResponse();
    }

    /**
     * @param array<string, mixed> $parameters
     * @throws InvalidParameterException
     * @throws MissingMandatoryParametersException
     * @throws RouteNotFoundException
     */
    protected function sendGetRequest(string $routeName, array $parameters = []): Response
    {
        $uri = $this->router->generate($routeName, $parameters);

        $this->client->request(self::GET_HTTP_METHOD, $uri);

        return $this->client->getResponse();
    }
}
