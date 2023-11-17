<?php
namespace App\Repositories\Eloquents;

use App\Models\Like;
use App\Models\User;
use App\Repositories\Contracts\UserRepository as ContractsUserRepository;
use App\Repositories\Repository;
use App\Traits\HasImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
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

    /**
     * @param UploadedFile $file
     * @param User|null $auth
     * @return string|null
     */
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
    /**
     * @param array $data
     * @return User|null
     */
    public function getInfo($data): ?User
    {
        return $this->model()->where('id', $data['id'])->with('images')->first();
    }

    /**
     * @param array $filters
     * @param User $user
     * @param array $columns
     * @return Collection
     */
    public function getAllFriends($filters, $user): array
    {
        $friendIds = $this->model()->find($user->id)->friends->pluck('friend_id')->toArray();
        return parent::getList($this->model()::whereIn('id', $friendIds), $filters);
    }

    /**
     * @param array $filters
     * @param User $user
     * @param array $columns
     * @return Collection
     */
    public function getAllNoneFriends($filters, $user): array
    {
        $friendIds = $this->model()->find($user->id)->friends->pluck('friend_id')->toArray();
        return parent::getList($this->model()::whereNotIn('id', $friendIds), $filters);
    }

    /**
     * Get list of options for user
     */
    public function getOptions(): array
    {
        $reactionOptions = collect(Like::EMOTIONS)
            ->map(fn ($label, $value) => compact('value', 'label'))
            ->values();

        return $reactionOptions->toArray();
    }
}
