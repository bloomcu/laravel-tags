<?php

namespace BloomCU\Tags\Scopes;

trait HasTagScopes
{
    // Check if model has any tags provided
    public function scopeWithAnyTag($query, array $tags)
    {
        return $query->hasTags($tags);
    }

    // Check that model has each tag provided
    public function scopeWithAllTags($query, array $tags)
    {
        foreach ($tags as $tag) {
            $query->hasTags([$tag]);
        }

        return $query;
    }

    public function scopeHasTags($query, array $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            return $query->whereIn('slug', $tags);
        });
    }
}
