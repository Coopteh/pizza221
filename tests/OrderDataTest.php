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
        $this->assertTrue($this->obj->validate($this->data), "Валидация должна пройти успешно для валидных данных.");
    }

    public function testValidateOrderDataEmptyFio(): void {
        $this->data['fio'] = ""; // Пустое ФИО
        $this->assertFalse($this->obj->validate($this->data), "Валидация должна провалиться для пустого ФИО.");
    }

    public function testValidateOrderDataInvalidPhone(): void {
        $this->data['phone'] = "123"; // Неверный номер телефона
        $this->assertFalse($this->obj->validate($this->data), "Валидация должна провалиться для неверного номера телефона.");
    }

    public function testValidateOrderDataInvalidEmail(): void {
        $this->data['email'] = "ivanov@.com"; // Неверный email
        $this->assertFalse($this->obj->validate($this->data), "Валидация должна провалиться для неверного email.");
    }

    public function testValidateOrderDataShortAddress(): void {
        $this->data['address'] = "Кемерово"; // Слишком короткий адрес
        $this->assertFalse($this->obj->validate($this->data), "Валидация должна провалиться для слишком короткого адреса.");
    }
}