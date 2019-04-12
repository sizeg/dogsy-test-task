#!/usr/bin/env php
<?php
// Switching arguments to have action first
if ($argc === 3) {
    [$_SERVER['argv'][1], $_SERVER['argv'][2]] = [$_SERVER['argv'][2], $_SERVER['argv'][1]];
    [$GLOBALS['argv'][1], $GLOBALS['argv'][2]] = [$GLOBALS['argv'][2], $GLOBALS['argv'][1]];
}

require __DIR__ . '/vendor/autoload.php';

$application = new \Symfony\Component\Console\Application('Dogsy', '1.0.0');
$application->add(new \App\Command\CountAverageLineCount());
$application->add(new \App\Command\ReplaceDates());
$application->run();
