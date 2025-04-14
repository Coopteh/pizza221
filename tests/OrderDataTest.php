<?php

namespace Tests;
use PHPUnit\Framework\TestCase;
use App\Services\ValidateOrderData;

class OrderDataTest extends TestCase 
{
    private array $data;
    private ValidateOrderData $obj;

    public function setUp():void {
        $this->data = [];
        $this->data['fio'] = "Иванов";
        $this->data['address'] = "Кемерово, ул.Тухачевского 32";
        $this->data['phone'] = "89007009911";
        $this->data['email'] = "ivanov@example.com";
        // Объект класса ValidateOrderData
        $this->obj = new ValidateOrderData();
    }

    public function testValidateOrderData(): void {
        $this->assertSame( true, 
                           $this->obj->validate($this->data) );
    }

    // ФИО - заполнено
    public function testInvalidFio(): void {
        $invalidFio = [
            'fio' => [],
        ];
        $this->assertSame(false, 
                          $this->obj->validate($invalidFio));
    }

    // адрес > 10
    public function testInvalidAddress(): void {
        $invalidAddress = [
            'address' => ''
        ];
        $this->assertSame(false, 
                          $this->obj->validate($invalidAddress));
    }


    // телефон - 11 цифр, 7 либо 8 в начале
    public function testInvalidPhone(): void {
        $this->data['phone'] = "1234567890"; 
        $this->assertFalse($this->obj->validate($this->data));
        $this->data['phone'] = "19007009911";
        $this->assertFalse($this->obj->validate($this->data));
    }

    // емайл - невалидные адреса проверить, типа "invalid", "@missing.username", ""
    public function testInvalidEmail(): void {
        $this->data['email'] = "invalid";
        $this->assertFalse($this->obj->validate($this->data)); 
        $this->data['email'] = "@missing.username"; 
        $this->assertFalse($this->obj->validate($this->data));
        $this->data['email'] = "";
        $this->assertFalse($this->obj->validate($this->data));
    }
}