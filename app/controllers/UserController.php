<?php

// контроллер для регистрации/авторизации/личного кабинета пользователя
namespace app\controllers;
use app\models\User;
use shop\App;
use shop\Pagination;

/** @property User $model */
class UserController extends AppController
{
    
    public function credentialsAction()
    {
        if (!User::checkAuth()) {
            redirect('/' . 'user/login');
        }

        if (!empty($_POST)) {
            $this->model->load();

            if (empty($this->model->attributes['password'])) {
                unset($this->model->attributes['password']);
            }
            unset($this->model->attributes['email']);

            if (!$this->model->validate($this->model->attributes)) {
                $this->model->getErrors();
            } else {
                if (!empty($this->model->attributes['password'])) {
                    $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                }

                if ($this->model->update('user', $_SESSION['user']['id'])) {
                    $_SESSION['success'] = 'Данные сохранены';
                    foreach ($this->model->attributes as $k => $v) {
                        if (!empty($v) && $k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                } else {
                    $_SESSION['errors'] = 'Ошибка сохранения';
                }
            }
            redirect();
        }

        $this->setMeta('Учетные данные');
    }

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
    
    public function cabinetAction()
    {
        if (!User::checkAuth()) {
            redirect('/' . 'user/login');
        }
        $this->setMeta('Кабинет');
    }
    
    public function ordersAction()
    {
        if (!User::checkAuth()) {
            redirect('/' . 'user/login');
        }

        $page = get('page');
//      $perpage = App::$app->getProperty('pagination');
        $perpage = 5;
        $total = $this->model->get_count_orders($_SESSION['user']['id']);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $orders = $this->model->get_user_orders($start, $perpage, $_SESSION['user']['id']);

        $this->setMeta('Просмотр заказа');
        $this->set(compact('orders', 'pagination', 'total'));
    }
    
    public function orderAction()
    {
        if (!User::checkAuth()) {
            redirect('/' . 'user/login');
        }

        $id = get('id');
        $order = $this->model->get_user_order($id);
        if (!$order) {
            throw new \Exception('Not found order', 404);
        }

        $this->setMeta('Просмотр заказа');
        $this->set(compact('order'));
    }
    
    public function filesAction()
    {
        if (!User::checkAuth()) {
            redirect('/' . 'user/login');
        }

        $page = get('page');
        $perpage = App::$app->getProrerty('pagination');
//      $perpage = 1;
        $total = $this->model->get_count_files();
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $files = $this->model->get_user_files($start, $perpage);
        $this->setMeta('Файлы для скачивания');
        $this->set(compact('files', 'pagination', 'total'));
    }
    
    public function downloadAction()
    {
        if (!User::checkAuth()) {
            redirect('/' . 'user/login');
        }

        $id = get('id');
        $file = $this->model->get_user_file($id);
        if ($file) {
            $path = WWW . "/downloads/{$file['filename']}";
            if (file_exists($path)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file['original_name']) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($path));
                readfile($path);
                exit();
            } else {
                $_SESSION['errors'] = 'Файл не найден';
            }
        }
        redirect();
    }
}

?>