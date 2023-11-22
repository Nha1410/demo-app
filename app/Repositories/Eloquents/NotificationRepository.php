<?php

namespace App\Repositories\Eloquents;

use App\Models\Notification;
use App\Models\User;
use App\Repositories\Contracts\NotificationRepository as ContractsNotificationRepository;
use App\Repositories\Repository;

class NotificationRepository extends Repository implements ContractsNotificationRepository
{
    /**
     * Returns the model associated with the repository.
     * @return string
     */
    public function getModel(): string
    {
        return Notification::class;
    }

    /**
     * Returns a list of notifications for a given user.
     *
     * @param array $filters
     * @param User $user
     * @param array $columns
     * @return array|null
     */

    public function getListNotification(array $filters = [], User $user, array $columns = ['*']): ?array
    {
        return parent::getList($user->notifications()->getQuery(), $filters, $columns);
    }
}