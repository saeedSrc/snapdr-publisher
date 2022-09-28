<?php

namespace Tests\Unit\Request;

use App\Rules\PersianPhoneRule;
use App\Rules\WithoutSpaceRule;
use Illuminate\Validation\Rule;
use App\Http\Requests\PushNotificationRequest;
use Tests\TestCase;

class PushNotificationRequestTest extends TestCase
{
    /**
     * @group unit
     * @dataProvider dataProvider
     */
//    public function testRulesShouldWork(PushNotificationRequest $request, array $expected): void
//    {
//        //act
//        $actual = $request->rules();
//
//        //assert
//        $this->assertEquals($expected, $actual);
//    }
//
//    public function dataProvider(): array
//    {
//        return [
//            'type is not valid' => [
//                new PushNotificationRequest(['type' => 'sms']),
//                [
//                    'type' => ['required', Rule::in(['sms', 'email'])],
//                    'to' => ['required', 'string', new WithoutSpaceRule()],
//                    'message' => ['required', 'string', 'max:10000'],
//                    'name' => ['required', 'string', 'max:100']
//                ]
//            ],
//            'type is equal to sms' => [
//                new PushNotificationRequest(['type' => 'email']),
//                [
//                    'type' => ['required', Rule::in(['sms', 'email'])],
//                    'to' => ['required', 'string', new WithoutSpaceRule()],
//                    'message' => ['required', 'string', 'max:10000'],
//                    'name' => ['required', 'string', 'max:100']
//                ]
//            ],
//            'type is equal to email' => [
//                new PushNotificationRequest(['type' => 'sms']),
//                [
//                    'type' => ['required', Rule::in(['sms', 'email'])],
//                    'to' => ['required', 'string', new WithoutSpaceRule()],
//                    'message' => ['required', 'string', 'max:10000'],
//                    'name' => ['required', 'string', 'max:100']
//                ]
//            ],
//        ];
//    }
}
