<?php
namespace App\Repositories\Contracts;

use App\Models\Comment;
use Illuminate\Support\Collection;

interface CommentRepository extends Repository
{
    public function store(array $data, $model): ?Comment;
    public function getCommentsByPostId(array $filters = [], $postId, array $columns = ['*']): ?array;
}