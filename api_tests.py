import requests

def test_get_post():
    response = requests.get("https://jsonplaceholder.typicode.com/posts/1")
    assert response.status_code == 200, "Ошибка: статус-код не 200!"
    assert "title" in response.json(), "Поле 'title' отсутствует в ответе!"

def test_get_users():
    response = requests.get("https://jsonplaceholder.typicode.com/users")
    users = response.json()
    assert len(users) > 0, "Список пользователей пуст!"
    for user in users:
        assert "id" in user, "Нет поля 'id'!"
        assert "name" in user, "Нет поля 'name'!"
        assert "email" in user, "Нет поля 'email'!"

def test_post_new_post():
    new_post = {
        "title": "Test Post",
        "body": "This is a test post",
        "userId": 1
    }
    response = requests.post("https://jsonplaceholder.typicode.com/posts", json=new_post)
    assert response.status_code == 201, "Ошибка: статус-код не 201!"
    assert "id" in response.json(), "Поле 'id' отсутствует в ответе!"

def test_get_post_headers():
    response = requests.get("https://jsonplaceholder.typicode.com/posts/1")
    headers = response.headers
    assert "application/json" in headers["Content-Type"], "Неверный Content-Type!"
    assert "cloudflare" in headers["Server"], "Сервер не Cloudflare!"

def test_put_and_delete_post():
    updated_data = {"title": "Updated Title"}
    response = requests.put("https://jsonplaceholder.typicode.com/posts/1", json=updated_data)
    assert response.status_code == 200, "Ошибка обновления!"

    response = requests.delete("https://jsonplaceholder.typicode.com/posts/1")
    assert response.status_code == 200, "Ошибка удаления!"


if __name__ == "__main__":
    test_get_post()
    test_get_users()
    test_post_new_post()
    test_get_post_headers()
    test_put_and_delete_post()
    print("Все тесты успешно пройдены!")
