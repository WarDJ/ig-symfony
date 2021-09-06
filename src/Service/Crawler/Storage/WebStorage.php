<?php

declare(strict_types=1);

namespace App\Service\Crawler\Storage;

use App\Entity\Crawler;
use App\Repository\CrawlerRepository;
use App\Service\Crawler\Parser\ParserResult;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class WebStorage
 * @package App\Service\Crawler\Storage
 */
class WebStorage implements StorageInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CrawlerRepository
     */
    private $repository;

    /**
     * WebStorage constructor.
     * @param EntityManagerInterface $entityManager
     * @param CrawlerRepository $repository
     */
    public function __construct(EntityManagerInterface $entityManager, CrawlerRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @param ParserResult $item
     * @return mixed|void
     */
    public function save(ParserResult $item)
    {
        $entity = $this->repository->findOneBy(['url' => $item->getUrl()]);

        if (empty($entity)) {
            $entity = new Crawler();
            $entity
                ->setUrl($item->getUrl())
                ->setCountImages($item->getCountImages());
        } else {
            $entity->setCountImages($item->getCountImages());
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}