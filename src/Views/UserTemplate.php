<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class UserTemplate extends BaseTemplate
{
    /*
        Формирование страница "Регистрация"
    */
    public static function getUserTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Вход пользователя';
        $content = <<<CORUSEL
        <main class="row p-5 justify-content-center align-items-center">
            <div class="col-5 bg-light border">
                <h3 class="mb-5">Вход пользователя</h3>
        CORUSEL;
        $content .= self::getFormLogin();
        $content .= "</div></main>";

        $resultTemplate =  sprintf($template, $title, $content);
        return $resultTemplate;
    }

    /* 
        Форма входа (логин, пароль)
    */
    public static function getFormLogin(): string {
        $html= <<<FORMA
                <form action="/pizza221/login" method="POST">
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Логин (имя или емайл):</label>
                        <input type="text" name="username" class="form-control" id="nameInput" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Пароль:</label>
                        <input type="password" name="password" class="form-control" id="passwordInput">
                    </div>
                    <button type="submit" class="btn btn-primary mb-3">Войти</button>
                </form>
        FORMA;
        return $html;
    }
    public static function getProfileForm(array $userData = []): string {
        $template = parent::getTemplate();
        $title = 'Редактирование профиля';
    
        $username = htmlspecialchars($userData['username'] ?? '');
        $email = htmlspecialchars($userData['email'] ?? '');
        $address = htmlspecialchars($userData['address'] ?? '');
        $phone = htmlspecialchars($userData['phone'] ?? '');
    
        // Упрощенный стиль без аватара
        $content = <<<HTML
        <style>
            /* Основные цвета - серые, элегантные */
            :root {
                --gray-light: #f5f5f7;
                --gray-medium: #b0b0b5;
                --gray-dark: #4a4a4a;
                --accent-color: #6e6e73; /* акцентный серый */
                --btn-bg: #4a4a4a;
                --btn-bg-hover: #3a3a3c;
                --input-border: #b0b0b5;
                --input-border-focus: #6e6e73;
                --text-color: #2c2c2e;
            }
    
            .custom-input-group {
                display: flex; 
                align-items: center; 
                border-radius: 10px; 
                overflow: hidden; 
                transition: border-color .3s ease; 
                background-color : var(--gray-light);
                border : 2px solid var(--input-border); 
            }
    
            .custom-input-group :focus-within {
                border-color : var(--input-border-focus);
            }
    
            .custom-input-group .input-group-text {
                display:flex; 
                align-items:center; 
                justify-content:center; 
                padding : 0 1rem; 
                background-color : transparent; 
                color : var(--accent-color); 
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
            }
    
            .btn-custom:hover {
                background-color: var(--btn-bg-hover);
            }
            
            main.row.p-4.justify-content-center.align-items-start > div.col-lg-6.col-md-8.bg-white.border.rounded.shadow.p-4.animate__animated.animate__fadeIn{
                 background-color:#f9f9fa !important; /* чуть светлее фон */
                 border-color:#dcdcdc !important; /* светло-серый бордер */
             }
             
             h3.text-center.mb-4{
                 color:#555555 !important; /* темно-серый заголовок */
             }
        </style>
        <main class="row p-4 justify-content-center align-items-start">
            <div class="col-lg-6 col-md-8 bg-white border rounded shadow p-4 animate__animated animate__fadeIn">
                 <h3 class="text-center mb-4">Редактирование профиля</h3>
    
                 <form action="/profile" method="POST" class="animate__animated animate__fadeInUp">
    
                     <!-- Имя пользователя -->
                     <div class="input-group mb-3 custom-input-group">
                         <span class="input-group-text">
                             <i class="fas fa-user-edit text-muted"></i>
                         </span>
                         <input type="text" name="username" class="form-control" value="{$username}" placeholder="Имя пользователя" required>
                     </div>
    
                     <!-- Email -->
                     <div class="input-group mb-3 custom-input-group">
                         <span class="input-group-text">
                             <i class="fas fa-envelope text-muted"></i>
                         </span>
                         <input type="email" name="email" class="form-control" value="{$email}" placeholder="Email" required>
                     </div>
    
                     <!-- Адрес -->
                     <div class="input-group mb-3 custom-input-group">
                         <span class="input-group-text">
                             <i class="fas fa-map-marker-alt text-muted"></i>
                         </span>
                         <input type="text" name="address" class="form-control" value="{$address}" placeholder="Адрес">
                     </div>
    
                     <!-- Телефон -->
                     <div class="input-group mb-3 custom-input-group">
                         <span class="input-group-text">
                             <i class="fas fa-phone text-muted"></i>
                         </span>
                         <input type="text" name="phone" class="form-control" value="{$phone}" placeholder="Телефон">
                     </div>
    
                     <!-- Кнопка -->
                     <div class="d-grid mt-4">
                         <button type="submit" class="btn btn-custom">
                             <i class="fas fa-save me-2"></i> Сохранить изменения
                         </button>
                     </div>
                 </form>
    
             </div>
         </main>
    HTML;
    
        // Вставляем содержимое в базовый шаблон
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    
    }

}