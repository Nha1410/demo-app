<?php

namespace App\Repositories\Eloquents;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository as ContractsPostRepository;
use App\Repositories\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostRepository extends Repository implements ContractsPostRepository
{
    /**
     * get model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return Post::class;
    }

    public function store(array $data)
    {
        $data['user_id'] = Auth::user()->id; 
        $post = $this->getModel()->fill($data);
        $post->user_id = Auth::user()->id;
        $post->save();
        // DB::beginTransaction(); 

        // try {
        //     $data['user_id'] = Auth::user()->id; 
        //     $post = $this->getModel()->fill($data);
        //     $post->user_id = Auth::user()->id;
        //     $post->save();
        //     DB::commit();
        //     return $post;
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     Log::error('Error while saving post: ' . $e->getMessage());
        //     return null;
        // }
    }
}