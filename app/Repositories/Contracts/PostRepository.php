<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostRepository extends Repository
{
    public function store(array $data): ?Post;
}