<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected array $filters;

    protected Builder $query;

    public function __construct(Builder $query, Request $request)
    {
        $this->query = $query;
        $this->filters = $request->query();
    }

    public function apply(): Builder
    {
        foreach ($this->filters as $name => $value) {
            $method = $this->filterToMethod($name);

            if (!is_callable(array($this, $method))) {
                continue;
            }

            $this->$method($value);
        }

        return $this->query;
    }

    private function filterToMethod($name): string
    {
        $words = explode('_', $name);
        foreach ($words as &$word) {
            $word = ucfirst($word);
        }

        return implode('', $words);
    }
}
