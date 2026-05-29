<?php

namespace App\Contracts;

use App\DTO\ExportChunkDTO;
use App\DTO\ExportStartDTO;

interface ExportServiceInterface
{
    public function start(int $requested, array $fields): ExportStartDTO;

    public function processChunk(string $exportId, int $lastId, int $remaining, array $fields): ExportChunkDTO;

    public function getFilePath(string $exportId): string;
}
