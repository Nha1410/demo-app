<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ImageRepository;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    protected const IMAGE_TYPE = 'post';

    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;
    protected $imageRepository;


    public function __construct(
        PostRepository $postRepository,
        ImageRepository $imageRepository
    ) {
        $this->postRepository = $postRepository;
        $this->imageRepository = $imageRepository;
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
        $post = $this->postRepository->store($request->all());

        if ($request->hasFile('image')) {
            $this->imageRepository->store($request->file('image'), self::IMAGE_TYPE , $post['id']);
        }

        return  $post ? response()->json($post) : response()->json([
            'message' => __('Created failure.'),
        ], Response::HTTP_BAD_REQUEST);
    }

    /*
    ** get list post and paginate
    */
    public function getList(Request $request): JsonResponse | JsonResource
    {
        $postList = $this->postRepository->getAll($request->all());

        return  $postList ? response()->json($postList) : response()->json([
            'message' => __('No data found.'),
        ], Response::HTTP_NOT_FOUND);
    }

    public function index()
    {
        return Inertia::render('Post/Index', []);
    }
}
