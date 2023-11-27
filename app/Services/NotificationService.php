<?php

namespace App\Services;

use App\Models\NotificationType;

class NotificationService extends Service
{
    /**
     * return a formatted string
     * @param User $user who do this action
     * @param NotificationType $type type of notification
     * @param Model $modelReceived action of notification
     */
    public function getTemplateTextNotification($user, $type, $modelReceived): string
    {
        $notificationTypes = config('const.notification_types');
        $userName = "<b>$user->name</b>";
        $templateText = NotificationType::where('id', '=', $type)->first()->value('template_text');

        switch($type) {
            case $notificationTypes['like_post']:
            case $notificationTypes['comment_post']:
            case $notificationTypes['tag_to_post']:
            case $notificationTypes['share_your_post']:
                // load post title
                return sprintf($templateText, $userName, "<b>$modelReceived->title</b>");
            case $notificationTypes['like_comment']:
            case $notificationTypes['replay_comment']:
            case $notificationTypes['tag_to_comment']:
                // load post comments content
                return  sprintf($templateText, $userName, "<b>$modelReceived->content</b>");
            default :
                return 'undefined template text';
        }
    }
}