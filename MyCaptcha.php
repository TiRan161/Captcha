<?php


class MyCaptcha
{
    public function get()
    {
        $strCap = '';
        chr(48);
        return $strCap;
    }

    function generateCode()
    {

//$chars = 'abdefhknrstyz23456789'; // Задаем символы, используемые в капче. Разделитель использовать не надо.
        $chars = $this->getChars();
// var_dump($chars);
        $length = 4; // Задаем длину капчи, в нашем случае - от 4 до 7
        $numChars = strlen($chars); // Узнаем, сколько у нас задано символов
        $str = '';
        for ($i = 0; $i < $length; $i++) {
// $str .= substr($chars, rand(1, $numChars) - 1, 1);
            $str .= $chars[rand(0, $numChars - 1)];
        } // Генерируем код
        $this->getImage($str);
        return $str;

// Перемешиваем, на всякий случай
        $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
        srand((float)microtime() * 1000000);
        shuffle($array_mix);
// Возвращаем полученный код

        return implode("", $array_mix);
    }

    function getChars()
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

    function getImage($str)
    {
        $width = 200;
        $height = 60;
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/Captcha/fonts/';
        $src = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($src, 255, 255, 255);
        imagefilledrectangle($src,0,0,200,100,($white));
        $x = rand(0, 10);
        $pixels = rand(2000, 4000);

        for ($i = 0; $i < strlen($str); $i++) {
            $x += rand(30, 40);
            $color = $white = imagecolorallocate($src, rand(0, 254), rand(0, 254), rand(0, 254));
            imagettftext($src, rand(20,40), rand(-25, 25), $x, 40, $color, $dir . "arial.ttf", $str[$i]);

        }
        for ($i = 0; $i < 4; $i++)
        {
            $color = imagecolorallocate($src, rand(0, 255), rand(0, 200), rand(0, 255));
            imageline($src, rand(0, 20), rand(1, 60), rand(150, 200), rand(1, 60), $color);
        }
        for ($i = 0; $i < $pixels; $i++) {
            $color = imagecolorallocate($src, rand(0, 200), rand(0, 200), rand(0, 200));
            imagesetpixel($src, rand(0, 200), rand(0, 200), $color);
        }
        echo $dir;

        //$white = imagecolorallocate($src, 255, 255, 255);
//        imagefilledrectangle($src,0,0, 200,60,$white);
        //imagettftext($src, 30, 0,10,40,$white,$dir."arial.ttf", $str);
        imagepng($src, $str . '.png');
        var_dump($src);
    }

}

$a = new MyCaptcha();
//gd_info();
echo $a->generateCode();