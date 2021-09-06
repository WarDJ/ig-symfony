<?php

declare(strict_types=1);

namespace App\Service\Crawler\Parser;

/**
 * Interface ParserInterface
 * @package App\Service\Crawler\Parser
 */
interface ParserInterface
{
    /**
     * @param string $url
     * @param int|null $depth
     * @param int|null $countPage
     * @return iterable
     */
    public function parseUrl(string $url, int $depth = 1, int $countPage = 1): iterable;
}