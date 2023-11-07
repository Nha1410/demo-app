<?php
namespace App\Repositories\Eloquents;

use App\Models\Friend;
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

}