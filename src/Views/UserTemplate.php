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
    public static function getProfileForm (array $userData = []): string {
        $template = parent::getTemplate();
        $title = 'Редактирование профиля';
    
        $username = htmlspecialchars($userData['username'] ?? '');
        $email = htmlspecialchars($userData['email'] ?? '');
        $address = htmlspecialchars($userData['address'] ?? '');
        $phone = htmlspecialchars($userData['phone'] ?? '');
        $avatar = htmlspecialchars($userData['avatar'] ?? '/assets/images/default-avatar.png'); // значение по умолчанию
        $content = <<<HTML
        <main class="row p-4 justify-content-center align-items-start">
            <div class="col-lg-6 col-md-8 bg-white border rounded shadow p-4 animate__animated animate__fadeIn">
                <h3 class="text-center mb-4" style="color: rgb(157, 167, 208);">Редактирование профиля</h3>
    
                <form action="/profile" method="POST" enctype="multipart/form-data" class="animate__animated animate__fadeInUp">
    
                    <!-- Аватар -->
                    <div class="avatar-wrapper">
                        <img src="{$avatar}" alt="Аватар пользователя" class="avatar-preview-form">
                        <label class="upload-btn">
                            <i class="fas fa-camera me-2"></i> Загрузить новый
                            <input type="file" name="avatar" accept="image/*">
                        </label>
                    </div>
    
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
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const avatarInput = document.querySelector('input[name="avatar"]');
                        const avatarPreview = document.querySelector('.avatar-preview-form');

                        if (avatarInput && avatarPreview) {
                            avatarInput.addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        avatarPreview.src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    // Если файл не выбран, возвращаем аватар по умолчанию
                                    avatarPreview.src = '/assets/images/default-avatar.png';
                                }
                            });
                        }
                    });
                </script>

            </div>
        </main>
        HTML;
    // Возвращаем сгенерированный HTML-код
    return $content;
    }

}