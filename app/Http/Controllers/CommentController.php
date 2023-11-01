<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CommentRepository;
use App\Repositories\Contracts\ImageRepository;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    protected $imageRepository;
    protected $commentRepository;
    protected $postRepository;

    public function __construct(
        ImageRepository $imageRepository,
        CommentRepository $commentRepository,
        PostRepository $postRepository,
    ) {
        $this->imageRepository = $imageRepository;
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function getList(Request $request): JsonResponse
    {
        return response()->json(array_reverse($this->commentRepository
            ->getCommentsByPostId($request->all(), $request->postId)));
    }
    /**
     * save comment in post
     */
    public function store(Request $request): JsonResponse
    {
        $post = $this->postRepository->find($request->postId);

        $comment = $this->commentRepository->store($request->all(), $post);

        if ($request->hasFile('image')) {
            $this->imageRepository->store($request->file('image'), $comment, $comment['id']);
        }

        return  $comment ? response()->json($comment) : response()->json([
            'message' => __('Created failure.'),
        ], Response::HTTP_BAD_REQUEST);
    }
}
