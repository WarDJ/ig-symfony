<?php

declare(strict_types=1);

namespace App\Service\Crawler\Parser;

/**
 * Class ParserResult
 * @package App\Service\Crawler
 */
class ParserResult
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var
     */
    private $countImages;

    /**
     * ParserResult constructor.
     * @param $url
     * @param $countImages
     */
    public function __construct($url, $countImages)
    {
        $this->url = $url;
        $this->countImages = $countImages;
    }

    /**
     * @return mixed
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getCountImages(): int
    {
        return $this->countImages;
    }


}