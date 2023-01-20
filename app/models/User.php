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
        'optional' => ['email', 'password'],
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

    public function get_count_orders($user_id): int
    {
        return R::count('orders', 'user_id = ?', [$user_id]);
    }

    public function get_user_orders($start, $perpage, $user_id): array
    {
        return R::getAll("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT $start, $perpage", [$user_id]);
    }
    
    public function get_user_order($id): array
    {
        return R::getAll("SELECT o.*, op.* FROM orders o JOIN order_product op on o.id = op.order_id WHERE o.id = ?", [$id]);
    }

    public function get_count_files(): int
    {
        return R::count('order_download', 'user_id = ? AND status = 1', [$_SESSION['user']['id']]);
    }

    public function get_user_files($start, $perpage): array
    {
        return R::getAll("SELECT od.*, d.*, dd.* FROM order_download od JOIN download d on d.id = od.download_id JOIN download_description dd on d.id = dd.download_id WHERE od.user_id = ? AND od.status = 1  LIMIT $start, $perpage", [$_SESSION['user']['id']]);
    }
    
    public function get_user_file($id): array
    {
        return R::getRow("SELECT od.*, d.*, dd.* FROM order_download od JOIN download d on d.id = od.download_id JOIN download_description dd on d.id = dd.download_id WHERE od.user_id = ? AND od.status = 1 AND od.download_id = ? ", [$_SESSION['user']['id'], $id]);
    }
}

?>