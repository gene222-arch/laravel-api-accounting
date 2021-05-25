<?php

namespace App\Traits\Cache;

trait CacheServices
{    
    /**
     * cacheKey
     *
     * @param  string $resource
     * @param  integer $resourceId
     * @param  string $subResource
     * @param  integer $subResourceId
     * @return string
     */
    public function cacheKey(string $resource, int $resourceId = null, string $subResource = null, int $subResourceId = null): string 
    {
        $key = "${resource}:";
        
        if ($resourceId) $key.= "${resourceId}:";

        if ($subResource) $key.= "${subResource}:";

        if ($subResourceId) $key.= "${subResourceId}:"; 

        return $key;
    }
}