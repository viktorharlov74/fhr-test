<?php

namespace App\Services\Sorting;

use App\Contracts\DataFileServiceInterface;
use Generator;

class DataFileService implements DataFileServiceInterface
{
    public function readLines(string $filePath, int $count): array
    {
        return iterator_to_array($this->readFromFile($filePath, $count), false);
    }

    private function readFromFile(string $path, int $limit): Generator
    {
        $handle = fopen($path, 'r');
        $read = 0;

        while (!feof($handle) && $read < $limit) {
            $line = trim(fgets($handle));

            if ($line !== '') {
                yield (int) $line;
                $read++;
            }
        }

        fclose($handle);
    }
}
