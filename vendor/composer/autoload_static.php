<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6713efcc7f9c310898d4505ce5b2fee8
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'A' => 
        array (
            'Asus\\Nganjukvisitnew\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Asus\\Nganjukvisitnew\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit6713efcc7f9c310898d4505ce5b2fee8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6713efcc7f9c310898d4505ce5b2fee8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6713efcc7f9c310898d4505ce5b2fee8::$classMap;

        }, null, ClassLoader::class);
    }
}
