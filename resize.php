<?php

$h = 5; // リサイズしたい大きさを指定
$w = 4;

//$file = $request->file; // 加工したいファイルを指定
//$file = imagecreatefrompng('028ari0173_0_b.png');
$file = imagecreatefrompng('037nao0023_1_b.png');
//$file = imagecreatefrompng('nck03.png');

// 新しく描画するキャンバスを作成
$canvas = imagecreatetruecolor($w, $h);
imagecopyresampled($canvas, $file, 0,0,0,0, $w, $h, 640, 800);

$resize_path = ('./new.png'); // 保存先を指定

imagepng($canvas, $resize_path, 9);

// 読み出したファイルは消去
imagedestroy($file);
imagedestroy($canvas);

?>
