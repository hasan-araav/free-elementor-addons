<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2c06edd0d964a682cb24193e9fa93a33
{
    public static $files = array (
        '2d4bad1d79a0b3943b961675f9462b59' => __DIR__ . '/../..' . '/app/helpers/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FreeElementorAddons\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FreeElementorAddons\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2c06edd0d964a682cb24193e9fa93a33::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2c06edd0d964a682cb24193e9fa93a33::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2c06edd0d964a682cb24193e9fa93a33::$classMap;

        }, null, ClassLoader::class);
    }
}