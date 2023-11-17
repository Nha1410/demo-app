<?php

namespace App\Repositories\Eloquents;

use App\Models\Like;
use App\Models\User;
use App\Repositories\Contracts\LikeRepository as ContractsLikeRepository;
use App\Repositories\Repository;

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
            $like = $this->model()->fill($data);
            $model->likes()->save($like);

            return $like;
        }, 'Like failed');
    }
}
