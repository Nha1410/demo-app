<?php

namespace App\Repositories\Eloquents;

use App\Models\FriendRequest;
use App\Models\User;
use App\Repositories\Contracts\FriendRequestRepository as ContractsFriendRequestRepository;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class FriendRequestRepository extends Repository implements ContractsFriendRequestRepository
{
    public function getModel(): string
    {
        return FriendRequest::class;
    }

    public function createFriendRequest(array $data, User $auth): mixed
    {
        return $this->handleSafely(function () use ($data, $auth) {
            $data['sender_id'] = $auth->id;
            $data['status'] = FriendRequest::SENDING_STATUS;
            $friendRequest = $this->model()->fill($data);
            $friendRequest->save();

            return $friendRequest;
        }, 'Create friend request');
    }

    public function getListFriendRequestByUserId(array $data, User $user): array
    {
        $senderRequestIds = $user->friendRequestsReceived
            ->where('status', '=' ,FriendRequest::SENDING_STATUS)
            ->pluck('sender_id')
            ->toArray();
        return parent::getList($user->whereIn('id', $senderRequestIds), $data);
    }
}
