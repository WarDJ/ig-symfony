<?php

declare(strict_types=1);

namespace App\Service\Crawler\Storage;

use App\Entity\Crawler;
use App\Repository\CrawlerRepository;
use App\Service\Crawler\Parser\ParserResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileStorage
 * @package App\Service\Crawler\Storage
 */
class FileStorage implements StorageInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * FileStorage constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param ParserResult $item
     * @return mixed|void
     */
    public function save(ParserResult $item)
    {
        //
    }
}