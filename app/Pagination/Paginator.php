<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator extends LengthAwarePaginator
{
    /**
     * Overrides the toArray method because the pagination for the homework doesn't contain any kind of metadata,
     * only the list of candidates.
     */
    public function toArray()
    {
        return $this->items->toArray();
    }
}
