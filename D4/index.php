<?php

const TEXT_LENGTH = 4;
const LINE_NUMBER = 10;
const NOISE_NUMBER = 10;
const NOISE_RADIUS = 50;
const NOISE_POINTS = 100;

// текст
$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefhijklmnopqrstuvwxyz1234567890';
$shuffle = str_shuffle($string);
$symbols = substr($shuffle, 0, TEXT_LENGTH);

// картинка
$height = 60;
$width = (32 * TEXT_LENGTH) + 30;
$image = imagecreate($width, $height);

imagecolorallocate($image, 255, 255, 255);

$noiseColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));

// точки шума
for ($j = 0; $j < NOISE_NUMBER; $j++) {
    $offsetX = rand(50, 100);
    $offsetY = rand(10, 100);

    for ($i = 0; $i < NOISE_POINTS; $i++) {
        $theta = 2 * M_PI * (mt_rand() / mt_getrandmax());
        $r = sqrt(mt_rand() / mt_getrandmax()) * NOISE_RADIUS;

        $x = $r * cos($theta) + $offsetX;
        $y = $r * sin($theta) + $offsetY;

        imagesetpixel($image, $x, $y, $noiseColor);
    }
}

// отрисовка символов
for ($i = 1; $i <= TEXT_LENGTH; $i++){
    $font = rand(22, 27);

    $r = rand(0, 255);
    $g = rand(0, 255);
    $b = rand(0, 255);

    $x = 15 + (30 * ($i - 1));
    $x = rand($x - 5, $x + 5);
    $y = rand(35, 45);
    $o = rand(-30, 30);

    $color = imagecolorallocate($image, $r ,$g, $b);

    imagettftext($image, $font, $o, $x, $y, $color, 'arial.ttf', $symbols[$i - 1]);
}

// отрисовка полосок
for($i = 1; $i <= LINE_NUMBER; $i++){
    $x1 = rand(1, 150);
    $y1 = rand(1, 150);

    $x2 = rand(1, 150);
    $y2 = rand(1, 150);

    $r = rand(0, 255);
    $g = rand(0, 255);
    $b = rand(0, 255);

    $color = imagecolorallocate($image, $r ,$g, $b);
    imageline($image, $x1, $y1, $x2, $y2, $color);
}

imagepng($image, "result.png");