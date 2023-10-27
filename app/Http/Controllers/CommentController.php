<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CommentRepository;
use App\Repositories\Contracts\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    protected $imageRepository;
    protected $commentRepository;

    public function __construct(
        ImageRepository $imageRepository,
        CommentRepository $commentRepository
    )
    {
        $this->imageRepository = $imageRepository;
        $this->commentRepository = $commentRepository;
    }
    public function store(Request $request)
    {
        $comment = $this->commentRepository->store($request->all());

        if ($request->hasFile('image')) {
            $this->imageRepository->store($request->file('image'), $comment, $comment['id']);
        }

        return  $comment ? response()->json($comment) : response()->json([
            'message' => __('Created failure.'),
        ], Response::HTTP_BAD_REQUEST);
    }
}
