<?php
namespace App\Repositories\Contracts;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Support\Collection;

interface FriendRepository extends Repository
{
    public function makeFriendRelationship(FriendRequest $friendRequest,User $auth);
}