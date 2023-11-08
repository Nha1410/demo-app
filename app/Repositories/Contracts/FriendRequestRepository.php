<?php
namespace App\Repositories\Contracts;

use App\Models\User;

interface FriendRequestRepository extends Repository
{
    public function createFriendRequest(array $data, User $auth): mixed;
    public function getListFriendRequestByUserId(array $data, User $user): array;
}