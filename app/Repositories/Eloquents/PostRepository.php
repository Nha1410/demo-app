<?php

namespace App\Repositories\Eloquents;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository as ContractsPostRepository;
use App\Repositories\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PostRepository extends Repository implements ContractsPostRepository
{


    /**
     * get model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel() : string
    {
        return Post::class;
    }

    public function store(array $data): ?Post
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = Auth::user()->id;
            $post = $this->model()->fill($data);
            $post->save();
            DB::commit();

            return $post->refresh();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error while saving post: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get All
     * @param  array  $filters
     * @param  array  $columns
     * @return mixed
     */
    public function getAll(array $filters = [], array $columns = ['*'])
    {
        $page = Arr::get($filters, 'page', 1);
        $perPage = Arr::get($filters, 'per_page', 10);

        // $post = Post::with('images')->find(103);
        // $images = $post->images; 
        // foreach ($images as $image) {
        //     $imageUrl = $image->image_path; 
        //     dd($image->image_path);
        // }

        return $this->model()->with('images')->orderByDesc('created_at')->take($perPage)->get();
    }
}