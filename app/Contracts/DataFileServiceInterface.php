<?php

namespace App\Contracts;

interface DataFileServiceInterface
{
    public function readLines(string $filePath, int $count): array;
}
