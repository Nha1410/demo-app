<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\FriendRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FriendController extends Controller
{
    protected $friendRepository;
    protected $userRepository;
    public function __construct(
        FriendRepository $friendRepository,
        UserRepository $userRepository
    ) {
        $this->friendRepository = $friendRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function addFriendTemplate(Request $request)
    {
        return Inertia::render('Friend/AddFriend', []);
    }

    public function getList(Request $request)
    {
        $user = Auth::user();
        $hasFriendship = $request->input('hasFriendship');
        if ($hasFriendship) {
            $friends = $this->userRepository->getAllFriends($request->all(), $user);
        } else {
            $friends = $this->userRepository->getAllNoneFriends($request->all(), $user);
        }

        return response()->json($friends);
    }
}
