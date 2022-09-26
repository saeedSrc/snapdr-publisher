<?php

namespace App\Http\Controllers;

use App\Domain\Notification;
use App\Http\Requests\PushNotificationRequest;
use App\Repo\NotificationInterface;
use App\Services\QueueInterface;
use App\Domain\Queue;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PushNotificationController extends Controller
{

    public function __construct(
        private QueueInterface $queueManager,
        private NotificationInterface $notificationRepository
    ) {
    }
    // here we also could use invokable class
    public function push(PushNotificationRequest $request): JsonResponse
    {
        $messageKey = uniqid(more_entropy: true);
        $this->insertNotification(Notification::getDataDomain($request->validated()), $messageKey);
        $this->publishMessageToQueue(Notification::getDataDomain($request->validated()), $messageKey);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    private function insertNotification(Notification $dto, string $messageKey): void
    {
        $notification = new \App\Models\Notification();
        $notification->to = $dto->to;
        $notification->name = $dto->name;
        $notification->message = $dto->message;
        $notification->type = $notification::getTypeDatabaseValue($dto->type);
        $notification->sent = false;
        $notification->message_key = $messageKey;
        $notification->created_at = now();
        $notification->updated_at = now();

        $this->notificationRepository->insert($notification);
    }

    private function publishMessageToQueue(Notification $dto, string $messageKey): void
    {
        $this->queueManager->publish(new Queue(
            Queue::QUEUE,
            [
                'to' => $dto->to,
                'name' => $dto->name,
                'message' => $dto->message,
                'type' => $dto->type,
                'key' => $messageKey
            ]
        ));
    }
}