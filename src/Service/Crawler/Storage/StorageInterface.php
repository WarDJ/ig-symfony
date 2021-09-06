<?php

declare(strict_types=1);

namespace App\Service\Crawler\Storage;

use App\Service\Crawler\Parser\ParserResult;

/**
 * Interface StorageInterface
 * @package App\Service\Crawler\Storage
 */
interface StorageInterface
{
    /**
     * @param ParserResult $item
     * @return mixed
     */
    public function save(ParserResult $item);
}