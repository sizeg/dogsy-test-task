<?php

namespace App\Command;

use App\Service\FindPeopleTextFiles;
use App\Service\ReadPeopleFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ReplaceDates
 * @author SiZE <sizemail@gmail.com>
 */
class ReplaceDates extends Command
{

    /**
     * @var string
     */
    protected static $defaultName = 'replaceDates';

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->addArgument('delimiter', InputArgument::REQUIRED, 'Delimiter');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = new \App\Service\ReplaceDates();

        $findPeopleTextFiles = new FindPeopleTextFiles();

        (new ReadPeopleFile())->read(function ($row) use ($service, $findPeopleTextFiles, $output) {
            if (sizeof($row) !== 2) {
                return;
            }
            [$id, $username] = $row;

            $totalReplaced = $service->replaceInFiles($findPeopleTextFiles->getListByPeopleId((int) $id));

            $output->writeln(sprintf('%s %s', $username, $totalReplaced));
        }, $input->getArgument('delimiter'));
    }
}