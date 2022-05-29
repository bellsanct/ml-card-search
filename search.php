<?php
$search_target = './outputs/037nao0063_1_b.png_.txt';
$search_file = fopen($search_target, 'r'); 

// whileで行末までループ処理
while (!feof($search_file)) {
  // fgetsでファイルを読み込み、変数に格納
  $search_bits = fgets($search_file);
  echo $search_bits . "\n";
  $pop1 = gmp_init($search_bits, 2);
  echo gmp_popcount($pop1) . "\n";
}

//$files = glob("./images/*.png");

$files = glob("./outputs/*.txt");
for($count = 0; $count < count($files); $count++) {
  $target_file = $files[$count];
  $target_bits = file_get_contents($target_file);
  //echo $target_bits . "\n";
}

?>
