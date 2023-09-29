<?php

namespace App\Repositories\Contracts;

use App\Models\Image;
use Illuminate\Http\UploadedFile;

interface ImageRepository extends Repository 
{
    public function store(UploadedFile $data , $postId = null): ?Image;
}