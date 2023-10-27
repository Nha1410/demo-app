<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface PostRepository extends Repository
{
    public function store(array $data, UploadedFile $file): ?Post;

    /**
     * Get All with paginator
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll();
}

