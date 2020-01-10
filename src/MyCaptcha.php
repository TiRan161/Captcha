<?php

namespace App;

class MyCaptcha
{
    public static function get()
    {
        $strCap = self::generateCode();
        self::getImage($strCap);
        return $strCap;
    }

    private static function generateCode()
    {

        $chars = self::getChars();
        $length = 4; // Задаем длину капчи
        $numChars = strlen($chars); // Узнаем, сколько у нас задано символов
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $numChars - 1)];
        }
        return $str;
    }

    private static function getChars()
    {
        // ASCII 48-57, 65-90, 97-122
        $chars = '';
        for ($i = 48; $i < 58; $i++) {
            $chars .= chr($i);
        }
        for ($i = 65; $i < 91; $i++) {
            $chars .= chr($i);
        }
        for ($i = 97; $i < 123; $i++) {
            $chars .= chr($i);
        }
        return $chars;
    }

    private static function getImage($str)
    {
        $width = 200;
        $height = 60;
        $src = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($src, 255, 255, 255);
        imagefilledrectangle($src, 0, 0, 200, 100, ($white));
        $x = rand(0, 10);
        $pixels = rand(2000, 4000);
        for ($i = 0; $i < strlen($str); $i++) {
            $x += rand(30, 40);
            $color = $white = imagecolorallocate($src, rand(0, 254), rand(0, 254), rand(0, 254));
            imagettftext($src, rand(25, 35), rand(-25, 25), $x, 40, $color, __DIR__.'/../fonts/arial.ttf', $str[$i]);

        }
        for ($i = 0; $i < 4; $i++) {
            $color = imagecolorallocate($src, rand(0, 255), rand(0, 200), rand(0, 255));
            imageline($src, rand(0, 20), rand(1, 60), rand(150, 200), rand(1, 60), $color);
        }
        for ($i = 0; $i < $pixels; $i++) {
            $color = imagecolorallocate($src, rand(0, 200), rand(0, 200), rand(0, 200));
            imagesetpixel($src, rand(0, 200), rand(0, 200), $color);
        }

        imagepng($src, self::createFolder().$str . '.png');
    }

    private static function createFolder()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/var';
        echo $dir;
        if (!is_dir($dir)) {
            mkdir($dir,0777,true);
        }
        $dir .= '/capture';
        if (!is_dir($dir)) {
            mkdir($dir,0777,true);
        }
        return $dir;
    }

}