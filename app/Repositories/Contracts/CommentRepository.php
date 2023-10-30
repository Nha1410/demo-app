<?php
namespace App\Repositories\Contracts;

use App\Models\Comment;

interface CommentRepository extends Repository
{
    public function store(array $data, $model): ?Comment;
}