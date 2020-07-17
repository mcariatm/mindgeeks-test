<?php

namespace App\Repositories;

use App\Item;
use GuzzleHttp\Client;

class ItemsRepository implements ItemsRepositoryInterface
{

    public function importOrUpdateItems()
    {
        $client = new Client();
        $response = $client->request("GET", 'https://mgtechtest.blob.core.windows.net/files/showcase.json');
        $items = json_decode(utf8_encode($response->getBody()));
        foreach($items as $item){
            $this->saveOrUpdateItem($item);
        }
    }

    private function saveOrUpdateItem($data)
    {
        if (isset($data->id)) {
            $item = Item::where('content->id', '=', $data->id)->first();
            if($item){
                $item->content = (array) $data;
                $item->status = Item::STATUSES['WAITING'];
            } else {
                $item = Item::create([
                    'content' => (array) $data,
                    'status' => Item::STATUSES['WAITING'],
                ]);
            }
            return $item->save();
        }
        return false;
    }
}
