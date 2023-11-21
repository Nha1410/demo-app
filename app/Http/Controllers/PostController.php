<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Contracts\ImageRepository;
use App\Repositories\Contracts\LikeRepository;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;
    protected $imageRepository;
    protected $likeRepository;


    public function __construct(
        PostRepository $postRepository,
        ImageRepository $imageRepository,
        LikeRepository $likeRepository,
    ) {
        $this->postRepository = $postRepository;
        $this->imageRepository = $imageRepository;
        $this->likeRepository = $likeRepository;
    }
    public function index()
    {
        return Inertia::render('Post/Index', []);
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
        $post = $this->postRepository->store($request->all(), $request->file('image'));

        return  $post ? response()->json($post) : response()->json([
            'message' => __('Created failure.'),
        ], Response::HTTP_BAD_REQUEST);
    }

    /*
    ** Get list post and paginate
    */
    public function getList(Request $request): JsonResponse | JsonResource
    {
        $postList = PostResource::collection($this->postRepository->getAll($request->all()));
        $postList->wrap('posts');

        return  $postList ? $postList : response()->json([
            'message' => __('No data found.'),
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Find specified Post.
     */
    public function show(Post $post): JsonResponse | JsonResource
    {
        return new PostResource($post);
    }

    /**
     * @param Request $request
     * Like specific post
     */
    public function likeSpecificPost(Request $request, Post $post): JsonResponse | JsonResource
    {
        $like = $this->likeRepository->handleLikeAction($request->all(), Auth::user(), $post);


        return  $like ? response()->json(new PostResource($post->load('likes'))) : response()->json([
            'message' => __('Like failed.'),
        ], Response::HTTP_NOT_FOUND);
    }
}
