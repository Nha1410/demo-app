<?php

namespace App\Repositories\Eloquents;

use App\Models\FriendRequest;
use App\Models\User;
use App\Repositories\Contracts\FriendRequestRepository as ContractsFriendRequestRepository;
use App\Repositories\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class FriendRequestRepository extends Repository implements ContractsFriendRequestRepository
{
    public function getModel(): string
    {
        return FriendRequest::class;
    }

    /**
     * Create a new friend request.
     *
     * @param  array  $data
     * @param  \App\Models\User  $auth
     * @return \App\Models\FriendRequest
     */
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

    /**
     * Get a list of friend requests sent by a user.
     *
     * @param  array  $data
     * @param  \App\Models\User  $user
     * @return array
     */
    public function getListFriendRequestByUserId(array $data, User $user): array
    {
        $senderRequestIds = $user->friendRequestsReceived
            ->where('status', '=' ,FriendRequest::SENDING_STATUS)
            ->pluck('sender_id')
            ->toArray();
        return parent::getList($this->model()->with('sender')->whereIn('sender_id', $senderRequestIds), $data);
    }

    /**
     * Handle a friend request.
     *
     * @param  array  $data
     * @param  \App\Models\FriendRequest  $friendRequest
     * @return \App\Models\FriendRequest
     */
    public function handleFriendRequest(array $data, FriendRequest $friendRequest): FriendRequest
    {
        $acceptedStatus = Arr::get($data, 'accept', false);
        if ($acceptedStatus) {
            return parent::handleSafely(function () use ($data, $friendRequest) {
                $data['status'] = FriendRequest::ACCEPTED_STATUS;
                $friendRequest->fill($data)->save();

                return $friendRequest;
            });
        } else {
            return parent::handleSafely(function () use ($data, $friendRequest) {
                $friendRequest->status = FriendRequest::DECLINED_STATUS;
                $friendRequest->save();

                return $friendRequest;
            });
        }
    }
}
