<?php

namespace App\Repositories;

use App\Contracts\PersonRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PersonRepository implements PersonRepositoryInterface
{
    public function count(): int
    {
        return DB::table('persons')->count();
    }

    public function getChunk(array $fields, int $lastId, int $limit): Collection
    {
        return DB::table('persons')
            ->select(array_merge(['id'], $fields))
            ->where('id', '>', $lastId)
            ->orderBy('id')
            ->limit($limit)
            ->get();
    }
}
