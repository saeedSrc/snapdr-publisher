<?php

namespace App\Repo\MysqlNotification;

use App\Models\Notification;
use App\Repo\NotificationInterface;
use Illuminate\Support\Facades\DB;
use PDO;

class MysqlRepository implements NotificationInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connection()->getPdo();
    }

    public function insert(Notification $notification): Notification
    {
        $sql = 'INSERT INTO notifications' .
            '(`to`, `name`, `message`, `type`, `received`, `key`, `created_at`, `updated_at`)' .
            'VALUES (?,?,?,?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $notification->to,
            $notification->name,
            $notification->message,
            $notification->type,
            (int) $notification->received,
            $notification->key,
            $notification->created_at,
            $notification->updated_at
        ]);
        $notification->id = $this->pdo->lastInsertId();

        return $notification;
    }
}
