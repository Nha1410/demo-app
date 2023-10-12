<?php

namespace App\Repositories\Eloquents;

use App\Models\Image;
use App\Repositories\Contracts\ImageRepository as ContractsImageRepository;
use App\Repositories\Repository;
use App\Services\HandleImageService;
use Illuminate\Http\UploadedFile;
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

    public function store(UploadedFile $data, $image_type = '', $postId = null): ?Image
    {
        $path = $this->handleImageService->storeLocalStorage($data, $image_type , $postId);

        DB::beginTransaction();

        try {
            $image['path'] = $path;
            $image['image_link_type'] = $image_type;
            $image['image_link_id'] = $postId;
            $image_store = app()->make($this->getModel())->fill($image);
            $image_store->save();
            DB::commit();

            return $image_store->refresh();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error while saving image: ' . $e->getMessage());
            return null;
        }
    }
}