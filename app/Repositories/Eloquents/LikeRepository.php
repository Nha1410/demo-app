<?php

namespace App\Repositories\Eloquents;

use App\Models\Like;
use App\Models\User;
use App\Repositories\Contracts\LikeRepository as ContractsLikeRepository;

class LikeRepository extends Repository implements ContractsLikeRepository
{
    public function getModel(): string
    {
        return Like::class;
    }

    public function handleLikeAction($data, User $user, $model)
    {
        return $this->handleSafely(function () use ($data, $user, $model) {
            $data['user_id'] = $user->id;
            $data['emoji_type'] = $data->emoji_type;
            $like = $this->model()->fill($data);
            $like = $model->like()->save($like);

            return $like;
        }, 'Create friend request');
    }
}
