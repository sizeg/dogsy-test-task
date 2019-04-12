<?php

namespace App\Service;

/**
 * Class ReplaceDates
 * @author SiZE <sizemail@gmail.com>
 */
final class ReplaceDates
{

    /**
     * @param string $text
     * @return int
     */
    public function replaceDates(string &$text): int
    {
        $count = 0;

        // this pattern is for simplicity
        $text = preg_replace_callback('#\d{1,2}/\d{1,2}/\d{1,2}#', function ($matches) use (&$count) {
            $date = \DateTime::createFromFormat('d/m/y', $matches[0]);
            if ($date) {
                $count++;
                return $date->format('m-d-Y');
            }
            
            return $matches[0];
        }, $text);

        return $count;
    }

    /**
     * @param string $file full path name
     * @return int
     */
    public function replaceInFile(string $file): int
    {
        $text = file_get_contents($file) ?? '';
        $count = $this->replaceDates($text);
        $filename = basename($file);
        file_put_contents(dirname(__DIR__) . '/output_texts/' . $filename, $text);

        return $count;
    }

    /**
     * @param array $files
     * @return int
     */
    public function replaceInFiles(array $files): int
    {
        $count = 0;
        foreach ($files as $file) {
            $count += $this->replaceInFile($file);
        }

        return $count;
    }
}
