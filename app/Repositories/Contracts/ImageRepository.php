<?php

namespace App\Repositories\Contracts;

use App\Models\Image;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

interface ImageRepository extends Repository
{
    public function store(UploadedFile $data, $model, $modelId = null): ?Image;
}