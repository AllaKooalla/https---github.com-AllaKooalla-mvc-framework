<?php

// контроллер для регистрации/авторизации/личного кабинета пользователя
namespace app\controllers;
use app\models\User;

/** @property User $model */
class UserController extends AppController
{
    public function singupAction()
    {
        if (User::checkAuth())
        {
            redirect('/');
        }

        if (!empty($_POST))
        {
            $data = $_POST;
            $this->model->load($data);
            if (!$this->model->validate($data) || !$this->model->checkUnique())
            {
                $this->model->getErrors();
                $_SESSION['form_data'] = $data;
            } else
            {
                // хэшируем пароль
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('user'))
                {
                    $_SESSION['success'] = 'Учетная запись была создана';
                } else
                {
                    $_SESSION['errors'] = 'Ошибка регистрации';
                }  
            }
            redirect();
        }

        $this->setMeta('Регистрация');
    }

    // метод для входа пользователей
    public function loginAction()
    {
        if (User::checkAuth())
        {
            redirect('/');
        }

        if (!empty($_POST))
        {
            if ($this->model->login())
            {
                $_SESSION['success'] = 'Вы успешно авторизованы';
                redirect('/');
            } else
            {
                $_SESSION['errors'] = 'Логин/пароль введены неверно';
                redirect();     
            }
        }

        $this->setMeta('Авторизация');
    }
    
    // метод выхода из аккаунта
    public function logoutAction()
    {
        if (User::checkAuth())
        {
            unset($_SESSION['user']);
        }
        redirect('/' . 'user/login');
    }
}

?>