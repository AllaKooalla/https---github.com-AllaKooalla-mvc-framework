<?php

namespace app\models\admin;

// наследуем пользовательскую модель User, так как в ней уже есть необходимые методы
class User extends \app\models\User
{

    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }

}