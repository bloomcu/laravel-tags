<?php

namespace BloomCU\Tags\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

use BloomCU\Tags\Models\Tag;
use BloomCU\Tags\Scopes\HasTagScopes;

trait HasTags
{
    use HasTagScopes;

    /**
     * Get all attached tags to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // Add specific tags
    public function tag(array $tags)
    {
        return $this->syncTags($this->getTagModels($tags));
    }

    // Remove all tags, then add specific tags
    public function retag(array $tags)
    {
        $this->detachTags($this->tags);

        return $this->tag($tags);
    }

    // Remove specific tags
    public function untag(array $tags)
    {
        return $this->detachTags($this->getTagModels($tags));
    }

    // Remove all tags
    public function untagAll()
    {
        return $this->detachTags($this->tags);
    }

    // Sync tags
    private function syncTags(Collection $tags)
    {
        $sync = $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        // Increment counts
        foreach (Arr::get($sync, 'attached') as $attachedId) {
            $tags->where('id', $attachedId)->first()->increment('count');
        }
    }

    // Detach tags
    private function detachTags(Collection $tags)
    {
        $this->tags()->detach($tags);

        // Decrement counts
        foreach($tags->where('count', '>', 0) as $tag) {
            $tag->decrement('count');
        }
    }

    // Get tags from database, by their slug
    private function getTagModels(array $tags)
    {
        return Tag::whereIn('slug', $tags)->get();
    }
}
