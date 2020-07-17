<?php

namespace App\Http\Controllers;

use App\Item;
use App\Repositories\ItemsRepositoryInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\File;

class ItemsController extends Controller
{
    /**
     * The items repository instance.
     */
    protected $itemsRepo;

    /**
     * Create a new controller instance.
     *
     * @param  ItemsRepositoryInterface $itemsRepo
     * @return void
     */
    public function __construct(ItemsRepositoryInterface $itemsRepo)
    {
        $this->itemsRepo = $itemsRepo;
    }

    public function getImage($file){
        $type = 'image/jpg';
        $headers = ['Content-Type' => $type];
        $path = base_path() . '/public/images/' . $file;
        if(file_exists($path)){
            return new BinaryFileResponse($path, 200 , $headers);
        }
        abort(404);
    }

    public function getAllItems()
    {
        return response()->json(Item::all());
    }

    public function startImport(){
        try {
            $this->itemsRepo->importOrUpdateItems();
        }catch (\Exception $e){
            return response()->json(['status' => 'error','error' => $e->getMessage()], 500);
        }
        return response()->json(['status' => "downloading started"]);
    }
}
