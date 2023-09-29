<?php 
namespace  App\Services;

use App\Services\Service;
use Illuminate\Support\Facades\Storage;

class HandleImageService extends Service 
{
    public function storeLocalStorage($data, $type = '', $linked_id)
    {
        $fileName = time() . '.' . $data->getClientOriginalExtension();
        $path = 'images/'. $type . '/'.$linked_id .'/'.$fileName;
        
        Storage::disk('local')->put( $path, 'public');
        return $path;
    }    

    public function storeS3Storage() 
    {

    }
}