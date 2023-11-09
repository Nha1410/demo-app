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
        return parent::getList($this->model()->with('sender')->whereIn('sender_id', $senderRequestIds), $data);
    }

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
