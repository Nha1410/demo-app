<?php
namespace  App\Services;

use App\Services\Service;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class HandleImageService extends Service
{
    public function storeLocalStorage(UploadedFile $data, $type = '')
    {
        $filePath = now()->format('Ymd').'/'.str()->random(40);
        $path = "images/{$type}/{$filePath}.".$data->getClientOriginalExtension();

        $image = Image::make($data->getRealPath());
        if($type == 'avatar') {
            $image->resize(350, 300);
        }

        Storage::put($path, $image->encode());

        return $path;
    }

    public function storeS3Storage()
    {

    }
}