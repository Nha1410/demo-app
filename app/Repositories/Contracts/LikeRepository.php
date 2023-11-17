<?php

namespace App\Repositories\Contracts;

use App\Models\Like;
use App\Models\User;

interface LikeRepository extends Repository
{
    public function handleLikeAction($data, User $user, $model);
}
