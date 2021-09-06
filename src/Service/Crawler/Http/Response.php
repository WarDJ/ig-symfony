<?php

declare(strict_types=1);

namespace App\Service\Crawler\Http;

use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class Response
 * @package App\Service\Crawler\Http
 */
class Response
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function getResult()
    {
        try {
            return $this->response->getContent();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return bool
     * @throws TransportExceptionInterface
     */
    public function isSuccessful()
    {
        $statusCode = $this->response->getStatusCode();

        return $statusCode >= 200 && $statusCode < 300;
    }
}