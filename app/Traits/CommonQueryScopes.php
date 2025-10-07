<?php

namespace App\Traits;

trait CommonQueryScopes
{
    public function scopeFilterByDate($query, $date)
    {
        return $date ? $query->whereDate('date', $date) : $query;
    }

    public function scopeSearchByTitle($query, $search)
    {
        return $search ? $query->where('title', 'like', '%' . $search . '%') : $query;
    }
}