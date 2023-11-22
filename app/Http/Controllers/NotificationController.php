<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Repositories\Contracts\NotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    protected $notificationRepository;

    /**
     * NotificationController constructor.
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(
        NotificationRepository $notificationRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Get a list of notifications for a given user
     *
     * @param Request $request
     * @return JsonResponse|JsonResource
     */
    public function getListByUserId(Request $request): JsonResponse | JsonResource
    {
        $notifications = ($this->notificationRepository->getListNotification($request->all(), $request->user()));

        return  $notifications ? response()->json(NotificationResource::collection($notifications)) : response()->json([
            'message' => __('No data found.'),
        ], Response::HTTP_NOT_FOUND);
    }

}
