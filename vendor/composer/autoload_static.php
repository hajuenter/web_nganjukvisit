<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6713efcc7f9c310898d4505ce5b2fee8
{
    public static $prefixLengthsPsr4 = array(
        'Z' =>
        array(
            'ZipStream\\' => 10,
        ),
        'P' =>
        array(
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
            'PhpOffice\\PhpSpreadsheet\\' => 25,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' =>
        array(
            'Matrix\\' => 7,
        ),
        'C' =>
        array(
            'Complex\\' => 8,
        ),
        'A' =>
        array(
            'Asus\\Nganjukvisitnew\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array(
        'ZipStream\\' =>
        array(
            0 => __DIR__ . '/..' . '/maennchen/zipstream-php/src',
        ),
        'Psr\\SimpleCache\\' =>
        array(
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Http\\Message\\' =>
        array(
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' =>
        array(
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'PhpOffice\\PhpSpreadsheet\\' =>
        array(
            0 => __DIR__ . '/..' . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet',
        ),
        'PHPMailer\\PHPMailer\\' =>
        array(
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Matrix\\' =>
        array(
            0 => __DIR__ . '/..' . '/markbaker/matrix/classes/src',
        ),
        'Complex\\' =>
        array(
            0 => __DIR__ . '/..' . '/markbaker/complex/classes/src',
        ),
        'Asus\\Nganjukvisitnew\\' =>
        array(
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array(
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
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
