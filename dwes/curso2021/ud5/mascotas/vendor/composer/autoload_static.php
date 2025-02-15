<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9eda143a2a048a918a163771d3164eac
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit9eda143a2a048a918a163771d3164eac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9eda143a2a048a918a163771d3164eac::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9eda143a2a048a918a163771d3164eac::$classMap;

        }, null, ClassLoader::class);
    }
}
