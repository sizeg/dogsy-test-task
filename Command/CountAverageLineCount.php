<?php

namespace App\Command;

use App\Service\FindPeopleTextFiles;
use App\Service\ReadPeopleFile;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CountAverageLineCount
 *
 * для каждого пользователя посчитать среднее количество строк в его текстовых файлах
 * и вывести на экран вместе с именем пользователя.
 *
 * @author SiZE <sizemail@gmail.com>
 */
class CountAverageLineCount extends Command
{

    /**
     * @var string
     */
    protected static $defaultName = 'countAverageLineCount';

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
        $service = new \App\Service\LineCount();

        $findPeopleTextFiles = new FindPeopleTextFiles();

        (new ReadPeopleFile())->read(function ($row) use ($service, $findPeopleTextFiles, $output) {
            if (sizeof($row) !== 2) {
                return;
            }
            [$id, $username] = $row;

            $averageLineCount= $service->averageLineCountInFiles($findPeopleTextFiles->getListByPeopleId((int) $id));

            $output->writeln(sprintf('%s %s', $username, $averageLineCount));
        }, $input->getArgument('delimiter'));
    }
}