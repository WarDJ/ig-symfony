<?php

declare(strict_types=1);

namespace App\Command\Parser;

use App\Service\Crawler\CrawlerService;
use App\Service\Crawler\CrawlerSettings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ParserCommand
 * @package App\Command\Parser
 */
class CrawlerCommand extends Command
{
    /**
     * @var CrawlerService
     */
    private $crawlerService;

    private $validator;

    /**
     * @var string
     */
    protected static $defaultName = 'crawler:run';

    /**
     * CrawlerCommand constructor.
     * @param CrawlerService $crawlerService
     */
    public function __construct(CrawlerService $crawlerService, ValidatorInterface $validator)
    {
        $this->crawlerService = $crawlerService;
        $this->validator = $validator;

        parent::__construct();
    }

    /**
     * Configured console command
     */
    protected function configure()
    {
        $this
            ->setDescription('Parser web pages')
            ->addArgument('url', InputArgument::REQUIRED, 'Input URL')
            ->addArgument('depth', InputArgument::OPTIONAL, 'Nesting depth')
            ->addArgument('max-pages', InputArgument::OPTIONAL, 'Max pages for parsing');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $depth = $input->getArgument('depth');
        $countPages = $input->getArgument('max-pages');

        $output->writeln('======= Start! =======');
        $output->writeln(sprintf('Parsing URL: %s', $url));

        $settings = new CrawlerSettings($url, (int)$depth, (int)$countPages);

        $errors = $this->validator->validate($settings);

        if ($errors->count()) {
            foreach ($errors as $error) {
                $output->writeln($error, $output::VERBOSITY_QUIET);
            }

            return Command::FAILURE;
        }

        $this->crawlerService->run($settings);

        return Command::SUCCESS;
    }
}