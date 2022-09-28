<?php

namespace Tests\Unit\Repo\Mysql;

use App\Models\Notification;

use App\Repo\MysqlNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MysqlRepoTest extends TestCase
{
    use DatabaseTransactions;

    public function testInsertShouldWork(): void
    {
        //arrange
        $notification = Notification::factory()->make();
        $repository = new MysqlNotification\MysqlRepository();

        //act
        $result = $repository->insert($notification);

        //assert
        $this->assertDatabaseHas('notifications', $notification->toArray());
        $this->assertNotNull($result->id);
    }
}
