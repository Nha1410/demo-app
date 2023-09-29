<?php

namespace App\Repositories\Contracts;

use App\Models\Image;

interface ImageRepository extends Repository 
{
    public function store($data , $postId = null): ?Image;
}