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

    public function validate(array $data): bool {
        // Проверка на пустое ФИО
        if (empty($data['fio'])) {
            return false;
        }

        // Проверка на адрес
        if (strlen($data['address']) < 10) {
            return false;
        }

        // Проверка на телефон
        if (!preg_match('/^(7|8)\d{10}$/', $data['phone'])) {
            return false;
        }

        // Проверка на email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true; // Все проверки пройдены
    }

    public function testValidateOrderData(): void {
        $this->assertSame(true, 
                          $this->obj->validate($this->data));
    }

    public function testInvalidFio(): void {
        $invalidFio = [
     
            'address' => "Кемерово, ул.Тухачевского 32",
            'phone' => "89007009911",
            'email' => "ivanov@example.com"
        ];
        
        $this->assertSame(false, 
                          $this->obj->validate($invalidFio));
    }

    public function testInvalidAddress(): void {
        $invalidAddress = [
            'fio' => "Иванов",
            'address' => "К", // адрес меньше 10 символов
            'phone' => "89007009911",
            'email' => "ivanov@example.com"
        ];
        
        $this->assertSame(false, 
                          $this->obj->validate($invalidAddress));
    }

    public function testInvalidPhone(): void {
        // Проверка на телефон с неправильным форматом
        $invalidPhone1 = [
            'fio' => "Иванов",
            'address' => "Кемерово, ул.Тухачевского 32",
            'phone' => "12345678901", // не начинается с 7 или 8
            'email' => "ivanov@example.com"
        ];
        
        $invalidPhone2 = [
            'fio' => "Иванов",
            'address' => "Кемерово, ул.Тухачевского 32",
            'phone' => "1234567", // слишком короткий номер
            'email' => "ivanov@example.com"
        ];

        $this->assertSame(false, 
                          $this->obj->validate($invalidPhone1));
                          
        $this->assertSame(false, 
                          $this->obj->validate($invalidPhone2));
    }

    public function testInvalidEmail(): void {
        // Проверка на невалидные email адреса
        $invalidEmail1 = [
            'fio' => "Иванов",
            'address' => "Кемерово, ул.Тухачевского 32",
            'phone' => "89007009911",
            'email' => "" // пустой email
        ];

        $invalidEmail2 = [
            'fio' => "Иванов",
            'address' => "Кемерово, ул.Тухачевского 32",
            'phone' => "89007009911",
            'email' => "@missing.username" // отсутствует часть до @
        ];

        $invalidEmail3 = [
            'fio' => "Иванов",
            'address' => "Кемерово, ул.Тухачевского 32",
            'phone' => "89007009911",
            'email' => "invalid" // некорректный email
        ];

        $this->assertSame(false, 
                          $this->obj->validate($invalidEmail1));
                          
        $this->assertSame(false, 
                          $this->obj->validate($invalidEmail2));

        $this->assertSame(false, 
                          $this->obj->validate($invalidEmail3));
    }
}