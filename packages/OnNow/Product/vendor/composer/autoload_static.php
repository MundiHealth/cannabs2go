<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcdb3d7a64961f2e3730df4679cb792b2
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OnNow\\Product\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OnNow\\Product\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcdb3d7a64961f2e3730df4679cb792b2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcdb3d7a64961f2e3730df4679cb792b2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
