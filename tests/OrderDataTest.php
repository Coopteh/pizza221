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
        $this->assertSame(true, 
                          $this->obj->validate($this->data));
    }

    // Набор тестов для невалидных данных
    public function testInvalidFio(): void {
        $invalidFio = [
            'fio' => '', // пустое ФИО
            'address' => 'Кемерово, ул.Тухачевского 32',
            'phone' => '89007009911',
            'email' => 'ivanov@example.com'
        ];
        $this->assertSame(false, 
                          $this->obj->validate($invalidFio));
    }

    public function testInvalidAddress(): void {
        $invalidAddress = [
            'fio' => 'Иванов',
            'address' => 'К', // адрес меньше 10 символов
            'phone' => '89007009911',
            'email' => 'ivanov@example.com'
        ];
        $this->assertSame(false, 
                          $this->obj->validate($invalidAddress));
    }

    public function testInvalidPhone(): void {
        // Тесты на невалидные телефоны
        $invalidPhones = [
            ['fio' => 'Иванов', 'address' => 'Кемерово, ул.Тухачевского 32', 'phone' => '1234567', 'email' => 'ivanov@example.com'], // слишком короткий номер
            ['fio' => 'Иванов', 'address' => 'Кемерово, ул.Тухачевского 32', 'phone' => '8900700991a', 'email' => 'ivanov@example.com'], // буквы в номере
            ['fio' => 'Иванов', 'address' => 'Кемерово, ул.Тухачевского 32', 'phone' => '', 'email' => 'ivanov@example.com'], // пустой номер
            ['fio' => 'Иванов', 'address' => 'Кемерово, ул.Тухачевского 32', 'phone' => '+79007009911', 'email' => 'ivanov@example.com'], // неверный формат (начинается с +)
        ];

        foreach ($invalidPhones as $invalidPhone) {
            $this->assertSame(false, 
                              $this->obj->validate($invalidPhone));
        }
    }

    public function testInvalidEmail(): void {
        // Тесты на невалидные email адреса
        $invalidEmails = [
            ['fio' => 'Иванов', 
             'address' => "Кемерово, ул.Тухачевского 32", 
             'phone' => "89007009911", 
             'email' => "invalid"], // некорректный email
            
            ['fio' => "Иванов", 
             "address" => "Кемерово, ул.Тухачевского 32", 
             "phone" => "89007009911", 
             "email" => "@missing.username"], // отсутствует имя пользователя
            
            ['fio' => "Иванов", 
             "address" => "Кемерово, ул.Тухачевского 32", 
             "phone" => "89007009911", 
             "email" => ""], // пустой email
            
            ['fio' => "Иванов", 
             "address" => "Кемерово, ул.Тухачевского 32", 
             "phone" => "89007009911", 
             "email" => "ivanov@.com"], // некорректный домен
        ];

        foreach ($invalidEmails as $invalidEmail) {
            $this->assertSame(false, 
                              $this->obj->validate($invalidEmail));
        }
    }
}