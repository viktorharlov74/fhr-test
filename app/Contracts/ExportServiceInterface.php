<?php

namespace App\Contracts;

interface ExportServiceInterface
{
    public function start(int $requested, array $fields): array;

    public function processChunk(string $exportId, int $lastId, int $remaining, array $fields): array;

    public function getFilePath(string $exportId): string;
}
