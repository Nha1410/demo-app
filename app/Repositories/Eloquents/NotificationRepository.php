<?php

namespace App\Repositories\Eloquents;

use App\Models\Notification;
use App\Models\NotificationActor;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Contracts\NotificationRepository as ContractsNotificationRepository;
use App\Repositories\Repository;
use App\Services\NotificationService;

class NotificationRepository extends Repository implements ContractsNotificationRepository
{
    protected $notificationService;

    public function __construct(
        NotificationService $notificationService
    ){
        $this->notificationService = $notificationService;
    }
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

    public function storeNewNotification(array $data, User $user, $modelReceived)
    {
        return $this->handleSafely(function() use ($data, $user, $modelReceived) {
            $data['target_id'] = $modelReceived->id;

            $data['content'] = $this->notificationService->getTemplateTextNotification($user, $data['notification_type_id'], $modelReceived);
            $notification = $this->model()->fill($data);
            $notification = $user->notifications()->save($notification);

            if(! is_null($notification)) {
                $this->storeNewNotificationActor($user, $notification);
            }

            return $notification;
        }, 'Create Notification failed');
    }

    public function storeNewNotificationActor($user, $notification)
    {
        $notificationActor = new NotificationActor;
        $notificationActor = $notificationActor->notifications()->save($user);

        return $notificationActor;
    }
}