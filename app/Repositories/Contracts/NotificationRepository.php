<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use App\Models\User;

interface NotificationRepository extends Repository
{
    /**
     * Get All with paginator
     * @return array
     */
    public function getListNotification(array $filters = [],User $user, array $columns = ['*']): ?array;
    public function storeNewNotification(array $data, User $user, $modelReciced);
}