<?php
namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Contracts\UserRepository as ContractsUserRepository;
use App\Repositories\Repository;
use App\Traits\HasImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserRepository extends Repository implements ContractsUserRepository
{
    use HasImage;

    public function getModel(): string
    {
        return User::class;
    }

    public function storeAvatar(UploadedFile $file, ?User $auth = null): string
    {
        DB::beginTransaction();

        try {
            $image = $this->storeImage($file);
            $auth->images()->save($image);

            $currentPath = $auth->profile_image_path;
            $auth->forceFill([
                'profile_image_path' => $image->path,
            ])->save();
            DB::commit();

            return $image->path;

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