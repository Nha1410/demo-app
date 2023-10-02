<?php
namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\UserRepository as ContractsUserRepository;
use App\Repositories\Repository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserRepository extends Repository implements ContractsUserRepository
{
    public function getModel(): string
    {
        return User::class;
    }

    public function storeAvatar($path, ?User $auth = null): string
    {
        DB::beginTransaction();

        try {
            $currentPath = $auth->profile_image_path;
            $auth->forceFill([
                'profile_image_path' => $path,
            ])->save();
            DB::commit();

            return $path;

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error while update user avatar: ' . $e->getMessage());
            return null;
        }
    }

    public function getInfo($data) : ?User
    {
        return $this->model()->where('id', $data['id'])->with('images')->first();
    }
}