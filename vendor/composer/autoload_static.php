<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit589490166fcc08778af402904602b811
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SurvTech\\Bnjunge\\Mariot\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SurvTech\\Bnjunge\\Mariot\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'SurvTech\\Bnjunge\\Mariot\\Config' => __DIR__ . '/../..' . '/src/Config.php',
        'SurvTech\\Bnjunge\\Mariot\\Delete' => __DIR__ . '/../..' . '/src/Delete.php',
        'SurvTech\\Bnjunge\\Mariot\\Insert' => __DIR__ . '/../..' . '/src/Insert.php',
        'SurvTech\\Bnjunge\\Mariot\\Select' => __DIR__ . '/../..' . '/src/Select.php',
        'SurvTech\\Bnjunge\\Mariot\\Update' => __DIR__ . '/../..' . '/src/Update.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit589490166fcc08778af402904602b811::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit589490166fcc08778af402904602b811::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit589490166fcc08778af402904602b811::$classMap;

        }, null, ClassLoader::class);
    }
}
