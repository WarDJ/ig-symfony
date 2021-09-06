<?php

declare(strict_types=1);

namespace App\Service\Crawler\Parser;

use App\Service\Crawler\Handler\ImageHandler;
use App\Service\Crawler\Handler\LinkHandler;
use App\Service\Crawler\Http\HttpClient;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class ParserWeb
 * @package App\Service\Crawler\Parser
 */
class ParserWeb implements ParserInterface
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
     * ParserWeb constructor.
     * @param LoggerInterface $logger
     * @param HttpClient $httpClient
     */
    public function __construct(LoggerInterface $logger, HttpClient $httpClient)
    {
        $this->logger = $logger;
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $url
     * @param int|null $depth
     * @param int|null $countPage
     * @return iterable
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function parseUrl(string $url, int $depth = 1, int $countPage = 1): iterable
    {
        $parseLinks = new ArrayCollection([$url]);

        while (!$parseLinks->isEmpty()) {
            if (!empty($countPage) && $parseLinks->key() - 1 == $countPage) {
                break;
            }

            $index = $parseLinks->key();

            try {
                $link = $parseLinks->current();

                $response = $this->httpClient->send($link);

                $imageCount = (new ImageHandler($link, $response))->getResult();
                $links = (new LinkHandler($link, $response))
                    ->setDepth($depth)
                    ->getResult();

                if (!empty($links) && $index === 0) {
                    array_map(function ($item) use ($parseLinks) {
                        if (!$parseLinks->contains($item)) {
                            $parseLinks->add($item);
                        }
                    }, $links);
                }

                yield new ParserResult($link, $imageCount);
            } catch (Exception $exception) {
                $this->logger->error(sprintf('Error: %s', $exception->getMessage()));
            }

            $parseLinks->next();

            $parseLinks->remove($index);
        }
    }
}