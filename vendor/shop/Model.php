<?php

namespace shop;

use RedBeanPHP\R;
use Valitron\Validator;

abstract class Model
{
    // данные из форм
    public array $attributes = [];
    public array $errors = [];
    // массив правил валидации
    public array $rules = [];
    // для указания, какое именно поле не прошло валидацию
    public array $labels = [];

    public function __construct()
    {
        Db::getInstance();
    }

    // метод заполняет массив значениями атрибутов из метода пост, то есть данными из формы регистрации
    public function load($post = true)
    {
        $data = $post ? $_POST : $_GET;
        foreach ($this->attributes as $name => $value) 
        {
            if (isset($data[$name])) 
            {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    // метод валидации данные, использует библиотеку vlucas/valitron
    public function validate($data): bool
    {
        Validator::langDir(ROOT . '/vendor/vlucas/valitron/lang');
        Validator::lang('ru');
        $validator = new Validator($data);
        $validator->rules($this->rules);
        $validator->labels($this->getLabels());
        if ($validator->validate())
        {
            return true;
        } else 
        {
            $this->errors = $validator->errors();
            debug($this->errors);
            return false;
        }
    }

    // метод собирает и показывает ошибки
    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error)
        {
            foreach ($error as $item)
            {
                $errors .= "<li>{$item}</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }

    public function getLabels(): array
    {
        $labels = [];
        foreach ($this->labels as $k => $v)
        {
            $labels[$k] = $v;
        }
        return $labels;
    }

    // метод для сохранения данных из формы в БД
    public function save($table): int|string
    {
        $tbl = R::dispense($table);
        foreach ($this->attributes as $name => $value)
        {
            if ($value != '')
            {
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }
    
    // обновление учетных данных о пользователе
    public function update($table, $id): int|string
    {
        $tbl = R::load($table, $id);
        foreach ($this->attributes as $name => $value) {
            if ($value != '') {
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }
}

?>