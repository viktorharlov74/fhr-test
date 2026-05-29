<?php

namespace App\DTO;

use JsonSerializable;

readonly class ExportChunkDTO implements JsonSerializable
{
    public function __construct(
        public int $processed,
        public int $lastId,
        public int $remaining,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'processed' => $this->processed,
            'last_id'   => $this->lastId,
            'remaining' => $this->remaining,
        ];
    }
}
