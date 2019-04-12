<?php

namespace App\Service;

/**
 * Class ReadPeopleFile
 * @author SiZE <sizemail@gmail.com>
 */
final class ReadPeopleFile
{

    /**
     * @var array
     */
    private $delimiters = ['comma' => ',', 'semicolon' => ';'];

    /**
     * @var resource
     */
    private $fp;

    /**
     * ReadPeopleFile constructor.
     */
    public function __construct()
    {
        $this->fp = fopen(__DIR__ . '/../people.csv', 'r');
        if (!$this->fp) {
            throw new \RuntimeException('Unable to open file "' . $this->file . '"');
        }
    }

    /**
     * @param callable $callback
     * @param string $delimiter
     */
    public function read(callable $callback, string $delimiter = 'comma'): void
    {
        if (!array_key_exists($delimiter, $this->delimiters)) {
            throw new \RuntimeException('Wrong delimiter "' . $delimiter . '". Allowed: ' . implode(', ', array_keys($this->delimiters)));
        }

        while (($row = fgetcsv($this->fp, 0, $this->delimiters[$delimiter])) !== false) {
            call_user_func($callback, $row);
        }
    }
}