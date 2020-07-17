<?php

namespace App\Jobs;

use App\Item;

class CacheImagesJob extends Job
{
    protected $item;

    /**
     * Create a new job instance.
     *
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $item = $this->item;
        $item->content = self::walkArray($item->content);
        $item->status = Item::STATUSES['DOWNLOADED'];
        $item->save();
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        $this->item->status = Item::STATUSES['ERROR'];
        $this->item->save();
    }

    private static function checkIfIsImage($string) {
        if(substr( $string, 0, 4 ) === "http" &&
            (substr( $string, -4) === ".jpg" || substr( $string, -4) === ".png")){
            return true;
        }
        return false;
    }

    private static function walkArray($array){
        foreach ($array as $key => $value) {
            if(is_array($value)){
                $array[$key] = self::walkArray($value);
            }elseif(self::checkIfIsImage($value)){
                $array['local_' . $key] = self::cacheImage($value);
            }
        }
        return $array;
    }

    private static function cacheImage($url)
    {
        $info = pathinfo($url);
        try {
            $contents = file_get_contents($url);
            $file = base_path() . '/public/images/' . $info['basename'];
            file_put_contents($file, $contents);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return '/images/' . $info['basename'];
    }
}
