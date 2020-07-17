<?php

namespace App\Observers;

use App\Item;
use App\Jobs\CacheImagesJob;

class ItemObserver
{
    /**
     * Handle the post "saved" event.
     *
     * @param  Item  $item
     * @return void
     */
    public function saved(Item $item)
    {
        if($item->status === Item::STATUSES['WAITING']){
            $job = (new CacheImagesJob($item))->onQueue('cache-images');
            dispatch($job);
        }
    }
}
