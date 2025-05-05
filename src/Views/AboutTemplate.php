<?php
namespace App\Views;
use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'О нас';
        $content = <<<HTML
        <div class="about-container">
            <h1>О нашем техникуме</h1>
            <p>Кемеровский кооперативный техникум — это учебное заведение, которое готовит специалистов в области экономики, управления и сервиса. Мы предлагаем качественное образование, которое сочетает теорию и практику, а также возможность получения дополнительных навыков.</p>
            <p>Наши студенты участвуют в различных конкурсах и мероприятиях, что позволяет им развивать свои способности и получать ценный опыт.</p>
            
            <div class="advantages">
                <h2>Наши преимущества:</h2>
                <ul class="advantages-list">
                    <li><i class="fas fa-chalkboard-teacher"></i> Квалифицированные преподаватели</li>
                    <li><i class="fas fa-book-open"></i> Современные учебные программы</li>
                    <li><i class="fas fa-tools"></i> Практическая направленность обучения</li>
                    <li><i class="fas fa-trophy"></i> Участие в конкурсах и проектах</li>
                </ul>
            </div>
            
            <div class="achievements">
                <h2>Наши достижения:</h2>
                <p>Мы гордимся тем, что наши студенты занимают призовые места на региональных и всероссийских конкурсах, а также активно участвуют в научных конференциях.</p>
                <img src="assets/images/dost.jpg" alt="Достижения техникума" class="achievement-image">
            </div>
            
            <div class="contact-info">
                <h2>Контактная информация:</h2>
                <p>Если у вас есть вопросы, вы можете связаться с нами по следующим контактам:</p>
                <ul>
                    <li><strong>Телефон:</strong> +7 (999) 123-45-67</li>
                    <li><strong>Email:</strong> info@kuzbass-tech.ru</li>
                    <li><strong>Адрес:</strong> ул. Тухачевского, 32, Кемерово</li>
                </ul>
            </div>
            
            <div class="map">
                <h2>Наше местоположение:</h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2269.376008805229!2d86.13175397728548!3d55.33398167293205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x42d80ece310b9bf3%3A0xc7432657230c1b7e!2z0YPQuy4g0KLRg9GF0LDRh9C10LLRgdC60L7Qs9C-LCAzMiwg0JrQtdC80LXRgNC-0LLQviwg0JrQtdC80LXRgNC-0LLRgdC60LDRjyDQvtCx0LsuLCA2NTAwNzA!5e0!3m2!1sru!2sru!4v1745877454418!5m2!1sru!2sru" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            
            <footer class="footer">
                <p>(*) Сайт разработан в рамках обучения в "Кузбасском кооперативном техникуме" по специальности "Специалист по информационным технологиям"</p>
            </footer>
        </div>
HTML;
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
?>