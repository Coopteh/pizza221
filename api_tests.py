import requests


# Задание 1: Настройка среды и первый GET-запрос
def test_get_post():
    response = requests.get("https://jsonplaceholder.typicode.com/posts/1")

    # Проверка статус-кода
    assert response.status_code == 200, "Ошибка: статус-код не 200!"

    # Проверка наличия поля "title"
    assert "title" in response.json(), "Поле 'title' отсутствует в ответе!"


# Задание 2: Проверка структуры ответа
def test_get_users():
    response = requests.get("https://jsonplaceholder.typicode.com/users")

    # Проверка, что список пользователей не пуст
    users = response.json()
    assert len(users) > 0, "Список пользователей пуст!"

    # Проверка наличия необходимых полей у каждого пользователя
    for user in users:
        assert "id" in user, "Нет поля 'id'!"
        assert "name" in user, "Нет поля 'name'!"
        assert "email" in user, "Нет поля 'email'!"


# Задание 3: Отправка POST-запроса
def test_post_new_post():
    new_post = {
        "title": "Test Post",
        "body": "This is a test post",
        "userId": 1
    }

    response = requests.post("https://jsonplaceholder.typicode.com/posts", json=new_post)

    # Проверка статус-кода
    assert response.status_code == 201, "Ошибка: статус-код не 201!"

    # Проверка наличия поля "id"
    assert "id" in response.json(), "Поле 'id' отсутствует в ответе!"


# Задание 4: Работа с заголовками (headers)
def test_get_post_headers():
    response = requests.get("https://jsonplaceholder.typicode.com/posts/1")

    headers = response.headers

    # Проверка заголовков ответа
    assert "application/json" in headers["Content-Type"], "Неверный Content-Type!"
    assert "cloudflare" in headers["Server"], "Сервер не Cloudflare!"


# Задание 5: Комплексный тест (PUT + DELETE)
def test_put_and_delete_post():
    updated_data = {"title": "Updated Title"}

    # Обновление поста через PUT-запрос
    response = requests.put("https://jsonplaceholder.typicode.com/posts/1", json=updated_data)
    assert response.status_code == 200, "Ошибка обновления!"

    # Удаление поста через DELETE-запрос
    response = requests.delete("https://jsonplaceholder.typicode.com/posts/1")
    assert response.status_code == 200, "Ошибка удаления!"


# Дополнительное задание: Тест для комментариев к посту с id=1
def test_get_comments_for_post():
    response = requests.get("https://jsonplaceholder.typicode.com/comments?postId=1")

    comments = response.json()

    # Проверка, что возвращаются комментарии к посту с id=1
    assert len(comments) > 0, "Нет комментариев для поста с id=1!"


# Запуск тестов
if __name__ == "__main__":
    test_get_post()
    test_get_users()
    test_post_new_post()
    test_get_post_headers()
    test_put_and_delete_post()
    test_get_comments_for_post()

print("Все тесты прошли успешно!")
