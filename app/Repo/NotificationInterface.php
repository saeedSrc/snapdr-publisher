<?php

namespace App\Repo;

use App\Models\Notification;

interface NotificationInterface
{
    public function insert(Notification $notification): Notification;
}
