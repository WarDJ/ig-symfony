<?php

declare(strict_types=1);

namespace App\Service\Crawler\Handler;

/**
 * Class ImageHandler
 * @package App\Service\Crawler\Handler
 */
class ImageHandler extends AbstractHandler
{
    /**
     * regex rule
     */
    public const REGEX = '/<[\s]*?img[^>]+src="([^">]+)"/';

    /**
     * extensions image
     */
    public const EXTENSIONS = ['jpg', 'jpeg', 'bmp', 'tiff', 'svg', 'png', 'gif'];

    /**
     * @return int|mixed
     */
    protected function handler(): int
    {
        $images = $this->get();

        if (empty($images)) {
            return 0;
        }

        $this->clear($images);

        return count($images);
    }

    /**
     * @param array $items
     * @return array|mixed
     */
    protected function clear(array &$items): void
    {
        $items = array_filter($items, function ($item) {
            if ($this->isCurrentUrl($item) && $this->validateExtension(self::EXTENSIONS, $item)) {
                return true;
            }
        });
    }

    /**
     * @return mixed|string
     */
    protected function getRegex(): string
    {
        return self::REGEX;
    }
}