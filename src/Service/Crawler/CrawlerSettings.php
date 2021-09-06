<?php

declare(strict_types=1);

namespace App\Service\Crawler;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CrawlerSettings
 * @package App\Service\Crawler
 */
class CrawlerSettings
{
    /**
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @var string
     */
    private $url;

    /**
     * @Assert\Positive
     * @var int
     */
    private $depth;

    /**
     * @Assert\Positive
     * @var int
     */
    private $countPage;

    /**
     * CrawlerSettings constructor.
     * @param string $url
     * @param int|null $depth
     * @param int|null $countPage
     */
    public function __construct(string $url, int $depth = 1, int $countPage = 1)
    {
        $this->url = $url;
        $this->depth = $depth;
        $this->countPage = $countPage;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int|null
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * @return int|null
     */
    public function getCountPage(): int
    {
        return $this->countPage;
    }

}