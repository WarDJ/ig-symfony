<?php

declare(strict_types=1);

namespace App\Service\Crawler\Handler;

/**
 * Class LinkHandler
 * @package App\Service\Crawler\Handler
 */
class LinkHandler extends AbstractHandler
{
    /**
     * regex rule
     */
    public const REGEX = '/<[\s]*?a[^>]+href="([^">]+)"/';
    /**
     * @var integer
     */
    private $depth;

    /**
     * @return array|int|mixed
     */
    protected function handler(): array
    {
        $links = $this->get();

        if (empty($links)) {
            return null;
        }

        $this->clear($links);

        return array_unique($links);
    }

    /**
     * @param array $items
     * @return array|mixed
     */
    protected function clear(array &$items): void
    {
        $this->fixURLs($items);

        $items = array_filter($items, function ($item) {
            if (isset($item) && $this->isCurrentUrl($item) && !pathinfo($item,
                    PATHINFO_EXTENSION) && $this->validateDepth($item)) {
                return true;
            }
        });
    }

    /**
     * @param $items
     */
    protected function fixURLs(&$items): void
    {
        $items = array_map(function ($url) {
            if (!$this->validateUrl($url) && $url != '/') {
                $url = sprintf('%s/%s', $this->getBaseUrl(), $url);

                return $url;
            }
        }, $items);
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function validateDepth(string $url): bool
    {
        $parsePath = explode('/', trim(parse_url($url, PHP_URL_PATH), '/'));

        return count($parsePath) <= $this->getDepth();
    }

    /**
     * @return int
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return $this
     */
    public function setDepth(int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @return mixed|string
     */
    protected function getRegex(): string
    {
        return self::REGEX;
    }

}