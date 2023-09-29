<?php 
namespace  App\Services;

use App\Services\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HandleImageService extends Service 
{
    public function storeLocalStorage(UploadedFile $data, $type = '', $linked_id)
    {
        $fileName = time() . '.' . $data->getClientOriginalExtension();
        $path = 'images/'. $type . '/'.$linked_id .'/'.$fileName;

        return $data->store($path);
    }    

    public function storeS3Storage() 
    {

    }
}