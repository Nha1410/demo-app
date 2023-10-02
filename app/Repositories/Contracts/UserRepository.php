<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface UserRepository extends Repository
{
    public function storeAvatar($path, ?User $auth = null): string;
    public function getInfo($data) : ?User;
}
