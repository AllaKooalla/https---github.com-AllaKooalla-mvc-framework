<?php

// модель для регистрации/авторизации/личного кабинета пользователя
namespace app\models;

use RedBeanPHP\R;

class User extends AppModel
{
    // безопасные данные, то есть получим только те данные, которые ожидали
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
    ];

    // массив для правил валидации, required - обязательные поля
    public array $rules = [
        'required' => ['email', 'password', 'name', 'address',],
        'email' => ['email',],
        'lengthMin' => [
            ['password', 6],
        ],
    ];

    public array $labels = [
        'email' => 'E-mail',
        'password' => 'Пароль',
        'name' => 'Имя',
        'address' => 'Адрес',
    ];

    // проверка аутенфикации
    public static function checkAuth(): bool
    {
        return isset($_SESSION['user']);
    }

    // метод для проверки уникальности поля email в форме 
    public function checkUnique($text_error = ''): bool
    {
        $user = R::findOne('user', 'email = ?', [$this->attributes['email']]);
        if ($user)
        {
            $this->errors['unique'][] = $text_error ?: 'Этот email уже зарегистрирован';
            return false;
        } else
        {
            return true;
        }
    }

    // метод для авторизации пользователей и админа
    public function login($is_admin = false): bool
    {
        $email = post('email');
        $password = post('password');
        if ($email && $password)
        {
            // проверка на админа
            if ($is_admin)
            {
                $user = R::findOne('user', "email = ? AND role = 'admin'", [$email]);
            } else
            {
                $user = R::findOne('user', "email = ?", [$email]);
            }

            // если получили пользователя, надо проверить пароль
            if ($user)
            {
                if (password_verify($password, $user->password))
                {
                    foreach ($user as $k => $v)
                    {
                        if (!$k != 'password')
                        {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }

}

?>