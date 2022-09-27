<?php

namespace App\Http\Controllers;

use App\Domain\NotificationDto;
use App\Http\Requests\PushNotificationRequest;
use App\Models\Notification;
use App\Repo\NotificationInterface;
use App\Services\QueueInterface;
use App\Domain\Queue;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PushNotificationController extends Controller
{

    public function __construct(
        private QueueInterface $queue,
        private NotificationInterface $notificationRepo
    ) {
    }
    // here we also could've used invokable class
    public function push(PushNotificationRequest $request): JsonResponse
    {
        $key = uniqid(more_entropy: true); // this key is used to make messages unique.
        DB::beginTransaction();
        try {
            $this->insertNotification(NotificationDto::getDataDomain($request->validated()), $key);
            $this->publishMessageToQueue(NotificationDto::getDataDomain($request->validated()), $key);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(trans("validation.general_response_err"), 422);
        }
        return response()->json("message pushed successfully");
    }


    private function insertNotification(NotificationDto $dto, string $key): void
    {
        $notification = new Notification();
        $notification->to = $dto->to;
        $notification->name = $dto->name;
        $notification->message = $dto->message;
        $notification->type = $notification::mapPushMethod($dto->type);
        $notification->received = false;
        $notification->key = $key;


        $this->notificationRepo->insert($notification);
    }

    private function publishMessageToQueue(NotificationDto $dto, string $key): void
    {
        $this->queue->publish(new Queue(
            Queue::QUEUE,
            [
                'to' => $dto->to,
                'name' => $dto->name,
                'message' => $dto->message,
                'type' => $dto->type,
                'key' => $key
            ]
        ));
    }
}
