<?php
namespace App\Traits;

use App\Models\Image;
use App\Services\HandleImageService;
use Illuminate\Http\UploadedFile;

trait HasImage
{
    protected $handleImageService;
    public function __construct(
        HandleImageService $handleImageService
    ) {
        $this->handleImageService = $handleImageService;
    }
    public function storeImage(UploadedFile $data)
    {
        $path = $this->handleImageService->storeLocalStorage($data,  $this->getModel());
        return new Image([
            'path' => $path,
        ]);
    }
}