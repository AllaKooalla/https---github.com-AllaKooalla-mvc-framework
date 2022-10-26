<?php

namespace shop;

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
}

?>