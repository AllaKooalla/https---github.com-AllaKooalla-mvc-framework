<?php

// реестр
namespace shop;

class Registry 
{
    use TSingleton;

    protected static array $properties = [];

    public function setProrerty($name, $value)
    {
        self::$properties[$name] = $value;
    }

    public function getProrerty($name)
    {
        return self::$properties[$name] ?? null;
    }

    // отладочный метод
    public function getProrerties(): array
    {
        return self::$properties;
    }
}

?>