<?php
namespace Views;

use Views\BaseTemplate;

class UserTemplate extends BaseTemplate {
    public function getLoginTemplate(): string 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <form method="post" action="/login">
            <!-- Login input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form2Example1">Логин:</label>
                <input type="text" name="login" id="form2Example1" class="form-control" required/>
                <div class="invalid-feedback">Поле обязательно к заполнению</div>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form2Example2">Пароль:</label>
                <input type="password" name="password" id="form2Example2" class="form-control" required/>
                <div class="invalid-feedback">Поле обязательно к заполнению</div>
            </div>

            <!-- Submit button -->
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Войти</button>
            </form>
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Вход', $str);
        return $resultTemplate;
    }


    public function getUsersTemplate($rows): string 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-8 offset-md-2">
        END;

        $str .= <<<END
        <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Логин</th>
            <th scope="col">Роль</th>
          </tr>
        </thead>
        <tbody>
        END;

        foreach($rows as $row)
            $str .= <<<LINE
                <tr>
                <td>{$row['id']}</td>
                <td>{$row['login']}</td>
                <td>{$row['role']}</td>
                </tr>
            LINE;

        $str .= <<<END
                </tbody>
            </table>        
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Список пользователей', $str);
        return $resultTemplate;
    }

    public function getFormTemplate() 
    {
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <form method="post" action="/add_user">
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example1">Логин:</label>
                    <input type="text" name="login" id="form2Example1" class="form-control" required/>
                    <div class="invalid-feedback">Поле обязательно к заполнению</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example2">Пароль:</label>
                    <input type="password" name="password" id="form2Example2" class="form-control" required/>
                    <div class="invalid-feedback">Поле обязательно к заполнению</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example3">Роль:</label>
                    <select class="form-select" name="role" aria-label="user" id="form2Example3">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Добавить</button>
            </form>
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        END;
        $resultTemplate =  sprintf($template, 'Добавление пользователя', $str);
        return $resultTemplate;   
    }
}