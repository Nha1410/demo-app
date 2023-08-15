<?php

namespace App\Repositories\Contracts;

use App\Models\Post;

interface PostRepository extends Repository
{
    public function store(array $data);
}