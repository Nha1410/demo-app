<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\ImageRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $userRepository;
    protected $imageRepository;
    public function __construct(
        UserRepository $userRepository,
        ImageRepository $imageRepository
    ) {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    public function editAvatar()
    {
        return Inertia::render('User/EditAvatar', []);
    }

    public function storeAvatar(Request $request)
    {
        if ($request->hasFile('image')) {
            $user = Auth::user();

            $path = $this->userRepository->storeAvatar($request->file('image'), $user);
            return response()->json($path);
        } else {
            response()->json([
                'message' => __('Created failure.'),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function getUserInfo(Request $request): JsonResponse | JsonResource
    {
        return  $this->userRepository->getInfo($request->user())
            ? response()->json($this->userRepository->getInfo($request->user()))
            : response()->json([
                'message' => __('No data found.'),
            ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Get a list of users as select box options.
     * And load config files for user actions
     */
    public function getOptions(): JsonResponse
    {
        $options = $this->userRepository->getOptions();
        $config = $this->userRepository->loadConfig();

        return response()->json(array_merge($options, $config));
    }
}
