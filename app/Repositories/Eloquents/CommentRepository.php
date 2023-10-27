<?php

namespace App\Repositories\Eloquents;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepository as ContractsCommentRepository;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentRepository extends Repository implements ContractsCommentRepository
{
    public function getModel(): string
    {
        return Comment::class;
    }

    public function store(array $data): ?Comment
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = Auth::user()->id;
            $comment = $this->model()->fill($data);
            $comment->save();
            DB::commit();

            return $comment->refresh();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error while saving post: ' . $e->getMessage());
            return null;
        }
    }
}