<?php
$dst_path = './1.png';//目标图片
$src_path = './icon-152.png';//水印图片

//创建图片的实例
$dst = imagecreatefromstring(file_get_contents($dst_path));
$src = imagecreatefromstring(file_get_contents($src_path));
//获取水印图片的宽高
list($src_w, $src_h) = getimagesize($src_path);
list($dst_w, $dst_h) = getimagesize($dst_path);

$width = abs(($src_w - $dst_w) /2);
$height = abs(($src_h - $dst_h)) /2;
imagecopymerge($dst, $src, $width, $height, 0, 0, $src_w, $src_h, 100);
list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
$filename = 'test';
switch ($dst_type) {
    case 1://GIF
        header('Content-Type: image/gif');
        imagegif($dst, $filename.'.gif');
        break;
    case 2://JPG
        header('Content-Type: image/jpeg');
        imagejpeg($dst, $filename.'.jpg');
        break;
    case 3://PNG
        header('Content-Type: image/png');
        imagepng($dst, $filename.'.png');
        break;
    default:
        break;
}

imagedestroy($dst);
imagedestroy($src);

