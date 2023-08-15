<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    /*
    ** show template for create new post
    */
    public function create()
    {
        return Inertia::render('Post/Create', []);
    }

    /*
    ** show template for create new post
    */
    public function store(Request $request): JsonResponse | JsonResource 
    {
        $post = $this->postRepository->create($request->all());

        return response()->json([

        ]);
    }

    /*
    ** get list post and paginate 
    */
    public function getList() {
        
    }
}
