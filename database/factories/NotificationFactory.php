<?php

namespace Database\Factories\Entities;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @method Notification make()
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'message' => $this->faker->sentence,
            'type' => $this->faker->randomElement([config('notif.sms_num'), config('notif.email_num')]),
            'received' => $this->faker->boolean,
            'key' => $this->faker->uuid,
            'to' => $this->faker->randomElement([$this->faker->email, $this->faker->phoneNumber]),
        ];
    }
}
