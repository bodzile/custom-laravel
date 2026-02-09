<?php

namespace Src\Queries;

final class QueryParts
{
    public function __construct(
        public array|string $select = [],
        public string $selectRaw = "",
        public bool $aggregates = false,
        public array $where = [
            "columns" => [],
            "sql" => ""
        ],
        public string $groupBy = "",
        public string $orderBy = "",
        public string $limit= ""
    ){}
}