<?php

namespace Laravie\SerializesQuery;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\JoinClause as JoinClauseBuilder;
use Illuminate\Support\Arr;

class JoinClause
{
    /**
     * Serialize to Join Clause Query Builder.
     */
    public static function serialize(JoinClauseBuilder $builder): array
    {
        return \array_merge(Query::serialize($builder), [
            'type' => $builder->type,
            'table' => $builder->table,
        ]);
    }

    /**
     * Unserialize to Join Clause Query Builder.
     */
    public static function unserialize(QueryBuilder $builder, array $joins): array
    {
        $results = [];

        foreach ($joins as $join) {
            $type = $join['type'];
            $table = $join['table'];

            $results[] = (new JoinClauseBuilder(
                Query::unserialize(Arr::except($join, ['type', 'table'])), $type, $table
            ))->newQuery();
        }

        return $results;
    }
}
