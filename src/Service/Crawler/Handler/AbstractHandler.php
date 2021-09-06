<?php

declare(strict_types=1);

namespace App\Service\Crawler\Handler;

use App\Service\Crawler\Traits\UrlTrait;

/**
 * Class AbstractHandler
 * @package App\Service\Crawler\Handler
 */
abstract class AbstractHandler
{
    use UrlTrait;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $content;

    /**
     * AbstractHandler constructor.
     * @param string $url
     * @param string $content
     */
    public function __construct(string $url, string $content)
    {
        $this->url = $url;
        $this->content = $content;
    }

    /**
     * @return array|mixed
     */
    public function getResult()
    {
        return $this->handler();
    }

    /**
     * @return mixed
     */
    abstract protected function handler();

    /**
     * @return array|mixed
     */
    public function get()
    {
        preg_match_all($this->getRegex(), $this->getContent(), $matches);

        return $matches[1] ?? [];
    }

    /**
     * @return mixed
     */
    abstract protected function getRegex(): string;

    /**
     * @return mixed
     */
    protected function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param $url
     * @return bool
     */
    protected function isCurrentUrl(string $url): bool
    {
        if (parse_url($url, PHP_URL_HOST) === parse_url($this->getUrl(), PHP_URL_HOST)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getUrl(): string
    {
        return rtrim($this->url, '/');
    }

    /**
     * @return string
     */
    protected function getBaseUrl()
    {
        $parseUrl = parse_url($this->getUrl());

        return $parseUrl['scheme'] . '://' . $parseUrl['host'];
    }

    /**
     * @param array $extList
     * @param string $url
     * @return bool
     */
    protected function validateExtension(array $extList, string $url): bool
    {
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        return in_array($extension, $extList);
    }

    /**
     * @param array $items
     * @return mixed
     */
    abstract protected function clear(array &$items): void;
}