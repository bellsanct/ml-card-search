<?php
//$B%j%5%$%:%5%$%:(B
$h = 10;
$w = 8;

$files = glob("./images/*.png");

for($count = 0; $count < count($files); $count++) {
  //$B%U%!%$%k$r(B1$B$D<hF@(B
  $target_file = $files[$count];
  $file = file_get_contents($target_file);
  $image = imagecreatefrompng($target_file);

  echo "Converting " . basename($target_file) . "..." . "\n";

  //$B?7$7$/IA2h$9$k%-%c%s%Q%9(B
  $canvas = imagecreatetruecolor($w, $h);
  imagecopyresampled($canvas, $image, 0, 0, 0, 0, $w, $h, 640, 800);

  imagefilter ( $canvas , IMG_FILTER_EDGEDETECT );
  imagefilter ( $canvas , IMG_FILTER_GRAYSCALE );
  imagefilter ( $canvas , IMG_FILTER_SMOOTH , 100 );
  imagefilter ( $canvas , IMG_FILTER_BRIGHTNESS , 20 );
  imagefilter ( $canvas , IMG_FILTER_CONTRAST , -255 );

  $resize_path = ('./results/' . $w . "x" . $h . "_" . basename($target_file));
  imagepng($canvas, $resize_path);

  //$B2hA|%G!<%?Id9f2=(B
  for($countY = 0 ; $countY < $h ; $countY++) {
    for($countX = 0 ; $countX < $w ; $countX++) {

      //$B:BI8$N?'<hF@(B
      $rgb = imagecolorat($canvas, $countX, $countY);
      $colors = imagecolorsforindex($canvas, $rgb);

      //$BNY@\2hAG<hF@(B
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

      //$B%U%!%$%k$K=q$-9~$`%S%C%HNs(B
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
  //$B2hA|$NGK4~(B
  imagedestroy($image);
  imagedestroy($canvas);
}
?>
