<?php

namespace Tests\Feature;

use App\Services\QueueInterface;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\Helpers;
use Tests\TestCase;

class PushNotificationControllerTest extends TestCase
{
    use DatabaseTransactions;

    private const PUSH_URI = '/api/push';

    /**
     * @group feature
     * @throws Exception
     */
//    public function testSuccessPushSms(): void
//    {
//        //arrange
////        $originData = array("to"=>"989121111111", "name"=>"john smith", "message"=>"hello john", "type" => "sms" );
//        $to = '09123860421';
//        $message = 'hi saeed';
//        $name = 'saeed rasooli';
//        $type = 'sms';
//        $data = compact('to', 'name', 'message', 'type');
//
//        $queueManager = $this->mock(QueueInterface::class);
//
//        //expect
//        $queueManager->shouldReceive('publish')->once();
//
//        //act
//        $response = $this->postJson(self::PUSH_URI, $data);
//
//        //assert
//        $response->assertStatus(200);
//        $this->assertDatabaseHas('notifications', [
//            'to' => $data["to"],
//            'name' => $data["name"],
//            'message' => $data["message"],
//            'type' => 1,
//            'received' => 0
//        ]);
//    }

    /**
     * @group feature
     */
//    public function testSuccessPushEmail(): void
//    {
//        //arrange
////        $originData = array("to"=>"foo@bar.com", "name"=>"John Doe", "message"=>'<b>Hello John</b>, <br /> <h3>Your order is ready.</h3>', "type" => "email" );
//        $to = 'saeed@yahoo.com';
//        $message = 'hi saeed';
//        $name = 'saeed rasooli';
//        $type = 'email';
//        $data = compact('to', 'name', 'message', 'type');
//        $queueManager = $this->mock(QueueInterface::class);
//
//        //expect
//        $queueManager->shouldReceive('publish')->once();
//
//        //act
//        $response = $this->postJson(self::PUSH_URI, $data);
//
//        //assert
//        $response->assertStatus(200);
//        $this->assertDatabaseHas('notifications', [
//            'to' => $data["to"],
//            'name' => $data["name"],
//            'message' => $data["message"],
//            'type' => 2,
//            'received' => 0
//        ]);
//    }


    /**
     * @group feature
     * @dataProvider invalidInputDataProvider
     */
    public function testPushInvalidInput(
        ?string $to,
        ?string $name,
        ?string $message,
        ?string $type,
    ): void {
        //arrange
        $data = compact('to', 'name', 'message', 'type');

        //act
        $response = $this->postJson(self::PUSH_URI, $data);
        $response->assertStatus(422);
    }

    public function invalidInputDataProvider(): array
    {
        return [
            'all inputs are null' => [
                null,
                null,
                null,
                null
            ],
            'type field is not valid' => [
                'foo@bar.com',
                'John Doe',
                'Lorem ipsum',
                'sss'
            ],
            'to field is not a valid phone number' => [
                'foo@me',
                'John Doe',
                'Lorem ipsum',
                'sms'
            ],
            'to field is not a valid email address' => [
                'bar@',
                'John Doe',
                'Lorem ipsum',
                'email'
            ],
        ];
    }
}
