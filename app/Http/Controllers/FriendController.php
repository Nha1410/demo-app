<?php

namespace App\Http\Controllers;

use App\Events\AddFriendNotification;
use App\Models\FriendRequest;
use App\Repositories\Contracts\FriendRepository;
use App\Repositories\Contracts\FriendRequestRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FriendController extends Controller
{
    protected $userRepository;
    protected $friendRepository;
    protected $friendRequestRepository;

    public function __construct(
        UserRepository $userRepository,
        FriendRepository $friendRepository,
        FriendRequestRepository $friendRequestRepository
    ) {
        $this->userRepository = $userRepository;
        $this->friendRepository = $friendRepository;
        $this->friendRequestRepository = $friendRequestRepository;
    }

    /**
     * Render the add friend template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function addFriendTemplate(Request $request)
    {
        return Inertia::render('Friend/AddFriend', []);
    }

    /**
     * Get a list of friends or non-friends.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request): JsonResponse
    {
        $user = Auth::user();
        $hasFriendship = $request->input('hasFriendship');
        if ($hasFriendship) {
            $friends = $this->userRepository->getAllFriends($request->all(), $user);
        } else {
            $friends = $this->userRepository->getAllNoneFriends($request->all(), $user);
        }

        return $friends
            ? response()->json($friends)
            : response()->json([
                'message' => __('No data found.'),
            ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Create a new friend request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFriendRequest(Request $request): JsonResponse
    {
        $friendRequest = $this->friendRequestRepository->createFriendRequest($request->all(), Auth::user());

        return $friendRequest
            ? response()->json($friendRequest)
            : response()->json([
                'message' => __('Send request fail.'),
            ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Get a list of friend requests sent by a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListFriendRequest(Request $request) : JsonResponse
    {
        $listFriendRequest = $this->friendRequestRepository->getListFriendRequestByUserId($request->all(), Auth::user());


        return $listFriendRequest
            ? response()->json($listFriendRequest)
            : response()->json([
                'message' => __('No data found.'),
            ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Handle a friend request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FriendRequest  $friendRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleFriendRequest(Request $request, FriendRequest $friendRequest): JsonResponse
    {
        $friendRequest = $this->friendRequestRepository->handleFriendRequest($request->all(), $friendRequest);

        if ($friendRequest && Arr::get($request->all(), 'accept', false)) {
            $this->friendRepository->makeFriendRelationship($friendRequest, Auth::user());
            broadcast(new AddFriendNotification($friendRequest));
        }

        return $friendRequest
            ? response()->json($friendRequest)
            : response()->json([
                'message' => __('Update failure'),
            ], Response::HTTP_BAD_REQUEST);
    }
}
