<?php
session_start();

define('WORKDIR',getcwd());

function randomkeys($length) {
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++) {
        $key .= $pattern[mt_rand(0,35)];
    }
    return $key;
}

// 配置项
$captcha_length = 6;
$image_width = 140;
$image_height = 40;
$font_file = WORKDIR.'/font/arial.ttf';

// 生成随机验证码字符串
$captcha_str = randomkeys(6);

// 将验证码字符串存储在会话中
$_SESSION['captcha'] = $captcha_str;
$_SESSION['verification_code_time'] = time();

// 创建空白图像
$image = imagecreatetruecolor($image_width, $image_height);

// 随机背景颜色
$bg_color = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));

// 填充整个图像
imagefill($image, 0, 0, $bg_color);

// 随机前景颜色
$text_color = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

// 在图像上绘制验证码字符串
$font_size = $image_height * 0.7;
$textbox = imagettfbbox($font_size, 0, $font_file, $captcha_str);
$x = ($image_width - $textbox[4]) / 2;
$y = ($image_height - $textbox[5]) / 2;
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font_file, $captcha_str);

// 添加干扰元素
for ($i = 0; $i < mt_rand(32, 64); $i++) {
    $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imageline($image, rand(0, $image_width), rand(0, $image_height), rand(0, $image_width), rand(0, $image_height), $color);
}

for ($i = 0; $i < mt_rand(32, 64); $i++) {
    $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($image, rand(0, $image_width), rand(0, $image_height), $color);
}

// 发送正确的MIME类型和缓存头到浏览器
header('Content-Type: image/png');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Expires: 0');

// 输出图像到浏览器
imagepng($image);

// 清理内存
imagedestroy($image);
