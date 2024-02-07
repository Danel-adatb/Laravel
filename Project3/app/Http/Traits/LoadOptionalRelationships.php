<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * We costumize here the relations, what can be used (include) but for ALL the actions
 * (for all the index, store, etc etc... except destroy, because obviously we are getting rid of the data)
 */
trait LoadOptionalRelationships {

    protected function shouldIncludeRelation(string $relation): bool {
        $include = request()->query('include');

        if(!$include) {
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
    public function loadRelationships(Model|EloquentBuilder|QueryBuilder|HasMany $for, ?array $relations = null): Model|EloquentBuilder|QueryBuilder|HasMany {
        $relations = $relations ?? $this->relations ?? [];

        foreach($relations as $relation) {
            $for->when(
                $this->shouldIncludeRelation($relation),
                fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }

        return $for;
    }
}
