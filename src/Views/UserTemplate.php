<?php 
namespace App\Views;

use App\Views\BaseTemplate;
use App\Configs\Config;

class UserTemplate extends BaseTemplate
{
    /*
        Формирование страницы "Регистрация"
    */
    public static function getUserTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Вход пользователя';
        $content = <<<CORUSEL
        <style>
            /* Основные цвета - серые, элегантные */
            :root {
                --gray-light: #f5f5f7;
                --gray-medium: #b0b0b5;
                --gray-dark: #4a4a4a;
                --accent-color: #6e6e73; /* акцентный серый */
                --btn-bg: rgba(74, 74, 74, 0.7); /* полупрозрачный серый */
                --btn-bg-hover: rgba(58, 58, 60, 0.8);
                --input-border: #b0b0b5;
                --input-border-focus: #6e6e73;
                --text-color: #2c2c2e;
            }

            body {
                background-color: var(--gray-light);
            }

            .custom-input-group {
                display: flex; 
                align-items: center; 
                border-radius: 10px; 
                overflow: hidden; 
                transition: border-color .3s ease; 
                background-color : white;
                border : 1px solid var(--input-border); 
            }

            .custom-input-group :focus-within {
                border-color : var(--input-border-focus);
            }

            .custom-input-group .form-control {
                border:none; 
                outline:none; 
                box-shadow:none; 
                padding : 0.75rem 1rem; 
                font-size : 1rem; 
                flex : 1; 
                color : var(--text-color); 
            }

            .btn-custom {
                background-color: var(--btn-bg);
                color: #fff;
                font-weight: bold;
                transition: all 0.3s ease;
                border: none;
                border-radius: 5px;
            }

            .btn-custom:hover {
                background-color: var(--btn-bg-hover);
            }
            
            main.row.p-4.justify-content-center.align-items-start > div.col-lg-6.col-md-8.bg-white.border.rounded.shadow.p-4.animate__animated.animate__fadeIn{
                 background-color:#ffffff !important; /* белый фон для формы */
                 border-color:#dcdcdc !important; /* светло-серый бордер */
                 box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* легкая тень */
             }
             
             h3.text-center.mb-4{
                 color:#333333 !important; /* темно-серый заголовок */
                 font-family: 'Arial', sans-serif;
                 font-weight: bold;
             }
        </style>
        <main class="row p-4 justify-content-center align-items-start">
            <div class="col-lg-6 col-md-8 bg-white border rounded shadow p-4 animate__animated animate__fadeIn">
                 <h3 class="text-center mb-4">Вход пользователя</h3>
                 <form action="/pizza221/login" method="POST" class="animate__animated animate__fadeInUp">
                     <!-- Логин -->
                     <div class="input-group mb-3 custom-input-group">
                         <span class="input-group-text">
                             <i class="fas fa-user text-muted"></i>
                         </span>
                         <input type="text" name="username" class="form-control" placeholder="Логин (имя или email)" required>
                     </div>

                     <!-- Пароль -->
                     <div class="input-group mb-3 custom-input-group">
                         <span class="input-group-text">
                             <i class="fas fa-lock text-muted"></i>
                         </span>
                         <input type="password" name="password" class="form-control" placeholder="Пароль">
                     </div>

                     <!-- Кнопка -->
                     <div class="d-grid mt-4">
                         <button type="submit" class="btn btn-custom">
                             Войти
                         </button>
                     </div>
                 </form>
             </div>
         </main>
        CORUSEL;

        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
    

    /*
        Формирование страницы "Профиль"
    */
    public static function getProfileTemplate(?array $data): string {
        $template = parent::getTemplate();
        $title= 'Профиль пользователя';
        
        // Подготовка данных пользователя
        $fio = htmlspecialchars($data[1] ?? "");
        $email = htmlspecialchars($data[2] ?? "");
        $address = htmlspecialchars($data[3] ?? "");
        $phone = htmlspecialchars($data[4] ?? "");

        // Содержимое формы профиля
        $content = <<<CORUSEL
        <style>
            /* Основные цвета - серые, элегантные */
            :root {
               --gray-light: #f5f5f7;
               --gray-medium: #b0b0b5;
               --gray-dark: #4a4a4a;
               --accent-color: #6e6e73; /* акцентный серый */
               --btn-bg: rgba(74, 74, 74, 0.7); /* полупрозрачный серый */
               --btn-bg-hover: rgba(58, 58, 60, 0.8);
               --input-border: #b0b0b5;
               --input-border-focus: #6e6e73;
               --text-color: #2c2c2e;
           }
           body {
               background-color: var(--gray-light);
           }
           .custom-input-group {
               display:flex; 
               align-items:center; 
               border-radius:10px; 
               overflow:hidden; 
               transition:border-color .3s ease; 
               background-color:white;
               border:1px solid var(--input-border); 
           }
           .custom-input-group :focus-within {
               border-color : var(--input-border-focus);
           }
           .custom-input-group .form-control {
               border:none; 
               outline:none; 
               box-shadow:none; 
               padding:.75rem 1rem; 
               font-size:1rem; 
               flex:1;  
           }
           
           .btn-custom {
              background-color: var(--btn-bg);
              color:#fff;
              font-weight:bold;
              transition:.3s ease all;
              border:none;
              border-radius:.25rem;
          }

          .btn-custom:hover {
              background-color:variables(btn-bg-hover);
          }
       </style>

       <main class="row p-4 justify-content-center align-items-start">
           <div class="col-lg-6 col-md-8 bg-white border rounded shadow p-4 animate__animated animate__fadeIn">
               <h3 class="text-center mb-4">Профиль пользователя</h3>

               <form action="/pizza221/profile" method="POST" class="animate__animated animate__fadeInUp">

                   <!-- Имя пользователя -->
                   <div class="input-group mb-3 custom-input-group">
                       <span class="input-group-text">
                           <i class="fas fa-user-edit text-muted"></i>
                       </span>
                       <input type="text" name="fio" class="form-control" disabled value="$fio">
                   </div>

                   <!-- Email -->
                   <div class="input-group mb-3 custom-input-group">
                       <span class="input-group-text">
                           <i class="fas fa-envelope text-muted"></i>
                       </span>
                       <input type="email" name="email" class="form-control" disabled value="$email">
                   </div>

                   <!-- Адрес -->
                   <div class="input-group mb-3 custom-input-group">
                       <span class="input-group-text">
                           <i class="fas fa-map-marker-alt text-muted"></i>
                       </span>
                       <input type="text" name="address" class="form-control" value="$address">
                   </div>

                   <!-- Телефон -->
                   <div class="input-group mb-3 custom-input-group">
                       <span class="input-group-text">
                           <i class="fas fa-phone text-muted"></i>
                       </span>
                       <input type="text" name="phone" class="form-control" value="$phone">
                   </div>

                   <!-- Кнопка -->
                   <div class='d-grid mt-4'>
                       <button type='submit' class='btn btn-custom'>
                           Обновить
                       </button>
                   </div>

               </form>

           </div>
       </main>        
       CORUSEL;

       // Вставляем содержимое в базовый шаблон
       $resultTemplate = sprintf($template, $title, $content);
       return $resultTemplate;

    }

    /*
        Формирование страницы "История заказов"
    */
    public static function getHistoryTemplate(?array $data): string {
        $template = parent::getTemplate();
        $title= 'История  заказов';
        $content = <<<CORUSEL
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-8 bg-light border">
                <h3 class="mb-5">История заказов</h3>
        CORUSEL;
        $content .= <<<TABLE
            <table class="table table-striped">
            <tr>    
                <th>Номер заказа</th>
                <th>Дата</th>
                <th>Сумма</th>
                <th>Статус</th>
            </tr>
        TABLE;
        if ($data)
        foreach($data as $row) {
            $orderDate = date("d-m-Y h:m", strtotime($row['created']));
            $nameStatus = Config::getStatusName( $row['status'] );
            $colorStyle = Config::getStatusColor( $row['status'] );
            $content .= <<<TABLE
            <tr>    
                <td>Заказ #{$row['id']}</td>
                <td>{$orderDate}</td>
                <td>{$row['all_sum']} ₽</td>
                <td class="{$colorStyle}">{$nameStatus}</td>
            </tr>
            TABLE;
        }
        
        $content .= '</table>';
        $content .= "</div></main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }
}