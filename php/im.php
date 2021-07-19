<?php
if (!empty($_GET['url'])) {
    $imagem = $_GET['url'];
}

$extensao = substr($imagem, -4);
if ($extensao[0] == '.') {
    $extensao = substr($imagem, -3);
}

if ($extensao == 'png') {
    $im = imagecreatefrompng($imagem);
    header('Content-type: image/png');
} else if ($extensao == 'jpg' or $extensao == 'jpeg') {
    $im = imagecreatefromjpeg($imagem);
    header("Content-type: image/jpeg");
} else if ($extensao == 'gif') {
    $im = imagecreatefromgif($imagem);
    header("Content-type: image/jpeg");
} else {
    $imagem='../img/noimage.png';
    $im = imagecreatefrompng($imagem);
    header('Content-type: image/png');
}
if (!empty($_GET['r'])) {
    $_GET['r'] = '';
} else {
    $_GET['r'] = 'ok';
}
if (!empty($_GET['w']) and empty($_GET['h'])) {
    $_GET['maxw'] = $_GET['w'];
    $_GET['w'] = '';
}
list($width, $height) = getimagesize($imagem);
if ($width > $height) {
    $prop = $width / $height;
} else {
    $prop = $height / $width;
}
if (!empty($_GET['w']) and $_GET['w'] > 0) {
    $l = $_GET['w'];
} else {
    $l = $width;
}
if (!empty($_GET['h']) and $_GET['h'] > 0) {
    $a = $_GET['h'];
} else {
    $a = $height;
}
$lr = $l;
if ($width >= $height) {
    $ar = $lr / $prop;
} else {
    $ar = $lr * $prop;
}
if ($ar <= $a) {
    $ar = $a;
    if ($width > $height) {
        $lr = $ar * $prop;
    } else {
        $lr = $ar / $prop;
    }
}
if ($lr > $l) {
    $left = round(($l - $lr) / 2);
} else {
    $left = 0;
}
if ($ar >= $a) {
    $top = round(($a - $ar) / 2);
} else {
    $top = 0;
}
if (!empty($_GET['maxw'])) {
    if ($lr > $_GET['maxw']) {
        $l = $lr = $_GET['maxw'];
    }
    if ($width > $height) {
        $ar = $lr / $prop;
        $a = $l / $prop;
    } else {
        $ar = $lr * $prop;
        $a = $l * $prop;
    }
} else if (!empty($_GET['maxh'])) {
    if ($ar > $_GET['maxh']) {
        $a = $ar = $_GET['maxh'];
    }
    if ($height > $width) {
        $lr = $ar / $prop;
        $l = $a / $prop;
    } else {
        $lr = $ar * $prop;
        $l = $a * $prop;
    }
}
if (empty($_GET['r'])) {
    if ($width >= $height) {
        if ($lr >= $l) {
            $lr = $l;
            $ar = $l * $prop;
        }
        if ($ar >= $a) {
            $ar = $a;
            $lr = $a * $prop;
        }
    } else {
        if ($lr <= $l) {
            $lr = $l;
            $ar = $l / $prop;
        }
        if ($ar <= $a) {
            $ar = $a;
            $lr = $a / $prop;
        }
    }
    $top = ($a - $ar) / 2;
    $left = ($l - $lr) / 2;
}
$im_final = imagecreatetruecolor($l, $a);


if (!empty($_GET['ext'])) {
    $extensao=$_GET['ext'];
}

$top=(!empty($_GET['top'])?$_GET['top']:(isset($_GET['top'])?0:$top));

if ($extensao == 'png') {
    imagealphablending($im_final, false);
    $col = imagecolorallocatealpha($im_final, 255, 255, 255, 127);
    imagefilledrectangle($im_final, 0, 0, $width, $height, $col);
    imagealphablending($im_final, true);
    imagecopyresampled($im_final, $im, $left, $top, 0, 0, $lr, $ar, $width, $height);
    imagealphablending($im_final, false);
    imagesavealpha($im_final, true);
    imagepng($im_final, null, 1);
    imagedestroy($im_final);
} else {
    $fundo = imagecolorallocate($im_final, 255, 255, 255);
    imagefill($im_final, 0, 0, $fundo);
    imagecopyresampled($im_final, $im, $left, $top, 0, 0, $lr, $ar, $width, $height);
    imagejpeg($im_final, null, 100);
}