<?php

declare(strict_types=1);

namespace App\Service\Crawler;

use App\Service\Crawler\Parser\ParserInterface;
use App\Service\Crawler\Parser\ParserResult;
use App\Service\Crawler\Storage\StorageInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CrawlerService
 * @package App\Service\Crawler
 */
class CrawlerService
{
    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CrawlerService constructor.
     * @param ParserInterface $parser
     * @param StorageInterface $storage
     * @param LoggerInterface $logger
     */
    public function __construct(ParserInterface $parser, StorageInterface $storage, LoggerInterface $logger)
    {
        $this->parser = $parser;
        $this->storage = $storage;
        $this->logger = $logger;
    }

    /**
     * @param CrawlerSettings $settings
     */
    public function run(CrawlerSettings $settings)
    {
        $generator = $this->parser->parseUrl($settings->getUrl(), $settings->getDepth(), $settings->getCountPage());

        foreach ($generator as $item) {
            /** @var ParserResult $item */
            $this->logger->notice(sprintf('URL: %s --- Count Image: %s', $item->getUrl(), $item->getCountImages()));

            $this->storage->save($item);
        }
    }

}