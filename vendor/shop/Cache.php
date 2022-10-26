<?php

// кэш
namespace shop;

class Cache
{
    // используем паттерн синглтон, чтобы от класса можно было создать только один объект
    // трейт обеспечит доступ к кэшу через метод getInstance()
    use TSingleton;

    // метод позволит записать в кэш
    // $key - ключ, по которому записываются данные в кэш
    // $data - сами данные
    // $seconds - время, на которое записываются данные
    // возвращает bool, то есть получилось или нет записать в кэш
    public function set($key, $data, $seconds = 3600): bool
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content)))
        {
            return true;
        } else
        {
            return false;
        }
    }

    // метод позволяет получить из кэша
    public function get($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file))
        {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time'])
            {
                return $content['data'];
            }
            unlink($file);
        }
        return false;
    }

    // метод для удаления данных из кэша
    public function delete($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file))
        {
            unlink($file);
        }
    }
}

?>