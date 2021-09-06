<?php

namespace App\Controller;

use App\Repository\CrawlerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @var CrawlerRepository
     */
    private $repository;

    /**
     * MainController constructor.
     * @param CrawlerRepository $repository
     */
    public function __construct(CrawlerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $urls = $this->repository->findAll();

        return $this->render('main/index.html.twig', [
            'urls' => $urls,
        ]);
    }
}
