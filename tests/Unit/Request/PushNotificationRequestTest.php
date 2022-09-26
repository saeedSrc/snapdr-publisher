<?php

namespace Tests\Unit\Request;

use App\Rules\PersianPhoneRule;
use Illuminate\Validation\Rule;
use App\Http\Requests\PushNotificationRequest;
use Tests\TestCase;

class PushNotificationRequestTest extends TestCase
{
    /**
     * @group unit
     * @dataProvider dataProvider
     */
    public function testRulesShouldWork(PushNotificationRequest $request, array $expected): void
    {
        //act
        $actual = $request->rules();

        //assert
        $this->assertEquals($expected, $actual);
    }

    public function dataProvider(): array
    {
        return [
            'type is not valid' => [
                new PushNotificationRequest(['type' => 'foo']),
                [
                    'to' => ['required', 'string', 'max:60', null],
                    'name' => ['required', 'string', 'max:60'],
                    'message' => ['required', 'string', 'max:10000'],
                    'type' => ['required', Rule::in(['sms', 'email'])]
                ]
            ],
            'type is equal to sms' => [
                new PushNotificationRequest(['type' => 'email']),
                [
                    'to' => ['required', 'string', 'max:60', 'email'],
                    'name' => ['required', 'string', 'max:60'],
                    'message' => ['required', 'string', 'max:10000'],
                    'type' => ['required', Rule::in(['sms', 'email'])]
                ]
            ],
            'type is equal to email' => [
                new PushNotificationRequest(['type' => 'sms']),
                [
                    'to' => ['required', 'string', 'max:60', new PersianPhoneRule()],
                    'name' => ['required', 'string', 'max:60'],
                    'message' => ['required', 'string', 'max:10000'],
                    'type' => ['required', Rule::in(['sms', 'email'])]
                ]
            ],
        ];
    }
}
