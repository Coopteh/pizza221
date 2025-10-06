<?php 

use PHPUnit\Framework\TestCase;
use App\Services\ValidateOrderData;

class OrderDataTest extends TestCase 
{
    private array $data;
    private ValidateOrderData $obj;

    public function setUp():void {
        // Массив валидных данных для передачи в метод
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
    public function testFioNotValidate(): void {
        unset($this->data['fio']);
        $this->assertSame( false, 
                           $this->obj->validate($this->data) );
    }
    // адрес > 10
    public function testAddressNotValidate(): void {
        $this->data['address'] = "Мало";
        $this->assertSame( false, 
                           $this->obj->validate($this->data) );
    }
    // телефон - 11 цифр, 7 либо 8 в начале
    public function testPhoneNotValidate(): void {
        $this->data['phone'] = "44-55-66";
        $this->assertSame( false, 
                           $this->obj->validate($this->data) );
        $this->data['phone'] = "19004556677";
        $this->assertSame( false, 
                            $this->obj->validate($this->data) );                           
    }
    // емайл - невалидные адреса проверить, типа "invalid", "@missing.username", ""
    public function testEmailNotValidate(): void {
        $this->data['email'] = "invalid";
        $this->assertSame( false,
                           $this->obj->validate($this->data) );
        $this->data['email'] = "@missing.username";
        $this->assertSame( false,
                            $this->obj->validate($this->data) );
        $this->data['email'] = "";
        $this->assertSame( false,
                            $this->obj->validate($this->data) );
    }
}