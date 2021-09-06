<?php

declare(strict_types=1);

namespace App\Service\Crawler\Http;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class HttpClient
 * @package App\Service\Crawler\Http
 */
class HttpClient
{

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * HttpClient constructor.
     * @param HttpClientInterface $httpClient
     * @param LoggerInterface $logger
     */
    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    /**
     * @param $url
     * @return string
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function send($url)
    {
        $request = $this
            ->getHttpClient()
            ->request('GET', $url);

        $response = new Response($request);

        if (!$response->isSuccessful()) {
            $this->getLogger()->error(sprintf('Status Code: %s', $response->getResponse()->getStatusCode()));
            $this->getLogger()->error(sprintf('URL: %s', $response->getResponse()->getInfo('url')));

            throw new Exception(sprintf('Url return status code: %s', $response->getResponse()->getStatusCode()));
        }

        return $response->getResult();
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}