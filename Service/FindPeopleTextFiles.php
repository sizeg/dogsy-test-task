<?php

namespace App\Service;

/**
 * Class ReadTextsFile
 * @author SiZE <sizemail@gmail.com>
 */
final class FindPeopleTextFiles
{

    /**
     * @param int $peopleId
     * @return array
     */
    public function getListByPeopleId(int $peopleId): array
    {
        $list = [];
        foreach (glob(dirname(__DIR__) . '/texts/' . DIRECTORY_SEPARATOR . $peopleId .'-????.txt') as $filename) {
            $list[] = $filename;
        }

        return $list;
    }
}