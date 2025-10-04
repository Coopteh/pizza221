<?php
use PHPUnit\Framework\TestCase;
use App\Services\ValidateOrderData;
class OrderDataTest extends TestCase 
{
    private array $data;
    private ValidateOrderData $obj;
    public function setUp(): void {
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
        $this->assertSame(false, $this->obj->validate($this->data));
    }
    public function testInvalidFio(): void {
      unset(  $this->data['fio']) ;
        $this->assertSame(false, $this->obj->validate($this->data));
    }
    public function testInvalidAddress(): void {
        $this->data['address'] = "Кем"; // Адрес менее 10 символов
        $this->assertSame(false, $this->obj->validate($this->data));
    }
    public function testInvalidPhoneTooShort(): void {
        $this->data['phone'] = "8900"; // Телефон менее 11 цифр
        $this->assertSame(false, $this->obj->validate($this->data));
    }
    public function testInvalidPhoneWrongStart(): void {
        $this->data['phone'] = "69007009911"; // Телефон не начинается с 7 или 8
        $this->assertSame(false, $this->obj->validate($this->data));
    }
    public function testInvalidEmailWithoutAt(): void {
        $this->data['email'] = "invalid"; // Неверный e-mail
        $this->assertSame(false, $this->obj->validate($this->data));
    }
    public function testInvalidEmailMissingUsername(): void {
        $this->data['email'] = "@missing.username"; // Неверный e-mail
        $this->assertSame(false, $this->obj->validate($this->data));
    }
}