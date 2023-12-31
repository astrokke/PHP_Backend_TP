<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6ee5cbfc997d975fc4d4881b6912bb4e
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nathan\\Project\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nathan\\Project\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6ee5cbfc997d975fc4d4881b6912bb4e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6ee5cbfc997d975fc4d4881b6912bb4e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6ee5cbfc997d975fc4d4881b6912bb4e::$classMap;

        }, null, ClassLoader::class);
    }
}
