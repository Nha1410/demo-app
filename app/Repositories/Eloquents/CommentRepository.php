<?php

namespace App\Repositories\Eloquents;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepository as ContractsCommentRepository;
use App\Repositories\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentRepository extends Repository implements ContractsCommentRepository
{
    public function getModel(): string
    {
        return Comment::class;
    }

    public function store(array $data, $model): ?Comment
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = Auth::user()->id;
            $comment = $this->model()->fill($data);
            $model->comments()->save($comment);

            DB::commit();

            return $comment->load('user');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error while saving post: ' . $e->getMessage());
            return null;
        }
    }

    public function getCommentsByPostId(array $filters = [], $postId, array $columns = ['*']): ?array
    {
        $page = Arr::get($filters, 'page', 1);
        $perPage = Arr::get($filters, 'per_page', 10);

        return $this->model()::where('commentable_type', 'App\Models\Post')
            ->where('commentable_id', $postId)
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate($perPage, $columns, 'page', $page)
            ->items();
    }
}