<?php

namespace Tests\Unit\Domain;

use App\DataTransferObjects\Notification\SendNotificationDto;
use App\Domain\NotificationDto;
use Tests\TestCase;

class NotificationDtoTest extends TestCase
{
    public function testGetDataDomain(): void
    {
        //arrange
        $originData = array("to"=>"989121111111", "name"=>"john smith", "message"=>"hello john", "type" => "sms" );

        //act
        $dto = NotificationDto::getDataDomain($originData);

        //assert
        $this->assertEquals($originData["to"], $dto->to);
        $this->assertEquals($originData["name"], $dto->name);
        $this->assertEquals($originData["message"], $dto->message);
        $this->assertEquals($originData["type"], $dto->type);
    }
}
