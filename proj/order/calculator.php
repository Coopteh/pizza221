<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1>Контактная форма</h1>
        <form id="contactForm">
            <!-- Поле для имени -->
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <!-- Поле для пароля -->
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Поле для email -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <!-- Радиокнопки для пола -->
            <div class="form-group">
                <label>Пол:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="male" required>
                        Мужской
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female">
                        Женский
                    </label>
                </div>
            </div>

            <!-- Выпадающий список -->
            <div class="form-group">
                <label for="country">Страна:</label>
                <select id="country" name="country" required>
                    <option value="">Выберите страну</option>
                    <option value="ru">Россия</option>
                    <option value="us">США</option>
                    <option value="de">Германия</option>
                </select>
            </div>

            <!-- Чекбокс для рассылки -->
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="newsletter">
                    Подписаться на рассылку
                </label>
            </div>

            <!-- Многострочное поле -->
            <div class="form-group">
                <label for="message">Сообщение:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>

            <!-- Кнопка отправки -->
            <button type="submit">Отправить</button>
        </form>
    </div>
</body>
</html>