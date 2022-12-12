<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1e637cda495e65cae14bd3060debf9da
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'shop\\' => 5,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'V' => 
        array (
            'Valitron\\' => 9,
        ),
        'R' => 
        array (
            'RedBeanPHP\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'shop\\' => 
        array (
            0 => __DIR__ . '/..' . '/shop',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Valitron\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/valitron/src/Valitron',
        ),
        'RedBeanPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/gabordemooij/redbean/RedBeanPHP',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1e637cda495e65cae14bd3060debf9da::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1e637cda495e65cae14bd3060debf9da::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1e637cda495e65cae14bd3060debf9da::$classMap;

        }, null, ClassLoader::class);
    }
}
