<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface PersonRepositoryInterface
{
    public function count(): int;

    public function getChunk(array $fields, int $lastId, int $limit): Collection;
}
