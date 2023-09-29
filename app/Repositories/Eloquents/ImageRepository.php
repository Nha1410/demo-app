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
    protected const IMAGE_TYPE = 'post';
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

    public function store(UploadedFile $data , $postId = null): ?Image
    {
        $path = $this->handleImageService->storeLocalStorage($data, self::IMAGE_TYPE , $postId);

        DB::beginTransaction();

        try {
            $image['path'] = $path;
            $image['image_type'] = self::IMAGE_TYPE;
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