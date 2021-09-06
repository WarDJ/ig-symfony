<?php

namespace App\Service\Crawler\Traits;

/**
 * Class UrlTrait
 * @package App\Traits
 */
trait UrlTrait
{
    /**
     * @param $url
     * @return bool
     */
    public function validateUrl(string $url): bool
    {
        return (bool)preg_match('/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/',
            $url);
    }
}