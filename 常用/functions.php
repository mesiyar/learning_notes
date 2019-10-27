<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2018/3/9
 * Time: 上午11:03
 */

/**
 * php 中没有毫秒级的函数
 * 作用  返回 毫秒级别的时间戳
 * @return float
 */
function msTime()
{
    list($msec, $sec) = explode(' ', microtime());
    $msTime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msTime;
}

function mergePhotos($photo1, $photo2, $filename)
{
    //创建图片的实例
    $dst = imagecreatefromstring(file_get_contents($photo1));
    $src = imagecreatefromstring(file_get_contents($photo2));
    //获取水印图片的宽高
    list($src_w, $src_h) = getimagesize($photo1);
    list($dst_w, $dst_h) = getimagesize($photo2);

    $width = abs(($src_w - $dst_w) /2);
    $height = abs(($src_h - $dst_h)) /2;
    imagecopymerge($dst, $src, $width, $height, 0, 0, $src_w, $src_h, 100);
    list($dst_w, $dst_h, $dst_type) = getimagesize($photo1);
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
}
