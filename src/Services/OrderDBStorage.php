<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практическая работа с Bootstrap</title>
    <!-- Подключение Bootstrap через CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Добавление кастомных стилей */
        body {
            background-color: #376da3;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.05); /* Увеличение карточки при наведении */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Заголовок страницы -->
    <h1 class="text-center mb-4">Добро пожаловать в наш проект!</h1>

    <div class="row mt-4">
        <!-- Первая колонка -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card p-3 border bg-light text-left">
                <h2 class="card-title">Информация о проекте</h2>
                <p class="m-3 font-weight-bold">Этот блок содержит информацию о нашем проекте и его целях.</p>
            </div>
        </div>

        <!-- Вторая колонка -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card p-3 border bg-light text-left">
                <h2 class="card-title">Команда проекта</h2>
                <p class="m-3 font-weight-bold">Здесь вы можете узнать о нашей команде и их ролях в проекте.</p>
            </div>
        </div>

        <!-- Третья колонка -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card p-3 border bg-light text-left">
                <h2 class="card-title">Контакты</h2>
                <p class="m-3 font-weight-bold">Свяжитесь с нами для получения дополнительной информации.</p>
            </div>
        </div>
    </div>
</div>

<!-- Подключил JavaScript и jQuery для работы Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>