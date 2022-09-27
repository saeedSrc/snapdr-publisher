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
    public function testSuccessPushSms(): void
    {
        //arrange
        $originData = array("to"=>"989121111111", "name"=>"john smith", "message"=>"hello john", "type" => "sms" );
        $data = (compact($originData["to"], $originData['name'], $originData['message'], $originData['type']));

        $queueManager = $this->mock(QueueInterface::class);

        //expect
        $queueManager->shouldReceive('publish')->once();

        //act
        $response = $this->postJson(self::PUSH_URI, $data);

        //assert
        $response->assertStatus(204);
        $this->assertDatabaseHas('notifications', [
            'to' => $originData["to"],
            'name' => $originData["name"],
            'message' => $originData["message"],
            'type' => 1,
            'received' => 0
        ]);
    }

    /**
     * @group feature
     */
    public function testSuccessPushEmail(): void
    {
        //arrange
        $originData = array("to"=>"foo@bar.com", "name"=>"John Doe", "message"=>'<b>Hello John</b>, <br /> <h3>Your order is ready.</h3>', "type" => "email" );
        $data = (compact($originData["to"], $originData['name'], $originData['message'], $originData['type']));
        $queueManager = $this->mock(QueueInterface::class);

        //expect
        $queueManager->shouldReceive('publish')->once();

        //act
        $response = $this->postJson(self::PUSH_URI, $data);

        //assert
        $response->assertStatus(204);
        $this->assertDatabaseHas('notifications', [
            'to' => $originData["to"],
            'name' => $originData["name"],
            'message' => $originData["message"],
            'type' => 2,
            'received' => 0
        ]);
    }


    /**
     * @group feature
     * @dataProvider invalidInputDataProvider
     */
    public function testPushInvalidInput(
        ?string $to,
        ?string $name,
        ?string $message,
        ?string $type,
        array $expectedKeys
    ): void {
        //arrange
        $data = compact('to', 'name', 'message', 'type');

        //act
        $response = $this->postJson(self::PUSH_URI, $data);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message' => $expectedKeys
        ]);
    }

    public function invalidInputDataProvider(): array
    {
        return [
            'all inputs are null' => [
                null,
                null,
                null,
                null,
                ['to', 'name', 'message', 'type']
            ],
            'type field is not valid' => [
                'foo@bar.com',
                'John Doe',
                'Lorem ipsum',
                'buzz',
                ['type']
            ],
            'to field is not a valid phone number' => [
                'foo',
                'John Doe',
                'Lorem ipsum',
                'sms',
                ['to']
            ],
            'to field is not a valid email address' => [
                'bar@',
                'John Doe',
                'Lorem ipsum',
                'email',
                ['to']
            ],
            'name field is too long, more than 60 characters which is the api limit' => [
                'foo@bar.com',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore',
                'Lorem ipsum',
                'email',
                ['name']
            ]
        ];
    }
}
