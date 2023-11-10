<?php
namespace App\Repositories\Eloquents;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Repositories\Contracts\FriendRepository as ContractsFriendRepository;
use App\Repositories\Repository;
use Illuminate\Support\Collection;

class FriendRepository extends Repository implements ContractsFriendRepository
{
    public function __construct()
    {

    }

    public function getModel(): string
    {
        return Friend::class;
    }

    public function makeFriendRelationship(FriendRequest $friendRequest, User $auth)
    {
        return parent::handleSafely(function () use ($friendRequest, $auth) {
            $data = [
                [
                    'user_id' => $auth->id,
                    'friend_id' => $friendRequest->sender_id,
                ],
                [
                    'friend_id' => $auth->id,
                    'user_id' => $friendRequest->sender_id,
                ]
            ];
            foreach ($data as $key => $value) {
                $friends = $this->model()->fill($value);
                $friends->save();
            }

            return response()->json(['status' => 'success'], 200);
        });
    }
}