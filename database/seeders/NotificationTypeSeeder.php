<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationType::create([
            'id' => 1,
            'name' => 'like_post',
            'display_name' => 'like post',
            'template_text' => '%s has liked your post %s'
        ]);
        NotificationType::create([
            'id' => 2,
            'name' => 'comment_post',
            'display_name' => 'comment post',
            'template_text' => '%s has comment on your post %s'
        ]);
        NotificationType::create([
            'id' => 3,
            'name' => 'like_comment',
            'display_name' => 'like comment',
            'template_text' => '%s has like your comment %s'
        ]);
        NotificationType::create([
            'id' => 4,
            'name' => 'reply_comment',
            'display_name' => 'reply comment',
            'template_text' => '%s has reply on your comment %s'
        ]);
        NotificationType::create([
            'id' => 5,
            'name' => 'tag_to_post',
            'display_name' => 'tag to post',
            'template_text' => '%s has tagged you on their post %s'
        ]);
        NotificationType::create([
            'id' => 6,
            'name' => 'tag_to_comment',
            'display_name' => 'tag to comment',
            'template_text' => '%s has tagged you to their comment %s'
        ]);
        NotificationType::create([
            'id' => 7,
            'name' => 'share_your_post',
            'display_name' => 'share your post',
            'template_text' => '%s has share your post %s'
        ]);
    }
}
