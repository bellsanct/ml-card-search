<?php
//リサイズサイズ
$h = 10;
$w = 8;

$files = glob("./images/*.png");

for($count = 0; $count < count($files); $count++) {
  //ファイルを1つ取得
  $target_file = $files[$count];
  $file = file_get_contents($target_file);
  $image = imagecreatefrompng($target_file);

  echo "Converting " . basename($target_file) . "..." . "\n";

  //新しく描画するキャンパス
  $canvas = imagecreatetruecolor($w, $h);
  imagecopyresampled($canvas, $image, 0, 0, 0, 0, $w, $h, 640, 800);

  imagefilter ( $canvas , IMG_FILTER_EDGEDETECT );
  imagefilter ( $canvas , IMG_FILTER_GRAYSCALE );
  imagefilter ( $canvas , IMG_FILTER_SMOOTH , 100 );
  imagefilter ( $canvas , IMG_FILTER_BRIGHTNESS , 20 );
  imagefilter ( $canvas , IMG_FILTER_CONTRAST , -255 );

  $resize_path = ('./results/' . $w . "x" . $h . "_" . basename($target_file));
  imagepng($canvas, $resize_path);

  //画像データ符号化
  for($countY = 0 ; $countY < $h ; $countY++) {
    for($countX = 0 ; $countX < $w ; $countX++) {

      //座標の色取得
      $rgb = imagecolorat($canvas, $countX, $countY);
      $colors = imagecolorsforindex($canvas, $rgb);

      //隣接画素取得
      if($countX > 0 && $count < $w) {
        $rgb_left = imagecolorat($image, $countX - 1, $countY);
        $colors_left = imagecolorsforindex($image, $rgb_left);
        $rgb_right = imagecolorat($image, $countX + 1, $countY);
        $colors_right = imagecolorsforindex($image, $rgb_right);
      } else {
        $rgb_left = imagecolorat($image, 0, $countY);
        $colors_left = imagecolorsforindex($image, $rgb_left);
        $rgb_right = imagecolorat($image, 0, $countY);
        $colors_right = imagecolorsforindex($image, $rgb_right);
      }

      //ファイルに書き込むビット列
      $string = "";

      if($rgb != 0) {
        $string = $string . "1";
      } else {
        $string = $string . "0";
      }

      file_put_contents("./outputs/" . basename($target_file , ".png") .".txt", $string , FILE_APPEND); 
    }
  }
  echo basename($target_file) . " -> " . basename($target_file, ".png") . ".txt" . "\n";
  //画像の破棄
  imagedestroy($image);
  imagedestroy($canvas);
}
?>
