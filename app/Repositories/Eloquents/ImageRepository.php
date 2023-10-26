<?php

namespace App\Repositories\Eloquents;

use App\Models\Image;
use App\Repositories\Contracts\ImageRepository as ContractsImageRepository;
use App\Repositories\Repository;
use App\Services\HandleImageService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageRepository extends Repository implements ContractsImageRepository
{
    protected $handleImageService;

    public function __construct (
        HandleImageService $handleImageService
    ) {
        $this->handleImageService = $handleImageService;
    }

    /**
     * get model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel() : string
    {
        return Image::class;
    }

    public function store(UploadedFile $data, Model|Authenticatable $model, $modelId = null): ?Image
    {
        $path = $this->handleImageService->storeLocalStorage($data,  $model::class, $modelId);

        DB::beginTransaction();

        try {
            $image = new Image([
                'path' => $path,
            ]);
    
            $model->images()->save($image);
            DB::commit();
            return $image->refresh();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error while saving image: ' . $e->getMessage());
            return null;
        }
    }
}