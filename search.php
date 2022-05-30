<?php
$search_target = './outputs/044miz0043_1_b.txt';

$search_file = fopen($search_target, 'r'); 
$array_results = array();

// whileで行末までループ処理
while (!feof($search_file)) {
  // fgetsでファイルを読み込み、変数に格納
  $search_bits = fgets($search_file);
  //echo $search_bits . "\n";
  //$pop1 = gmp_init($search_bits, 2);
  //echo gmp_popcount($pop1) . "\n";
}

$array_search_bits = str_split($search_bits);

//$files = glob("./images/*.png");

$files = glob("./outputs/*.txt");
for($count = 0; $count < count($files); $count++) {
  $target_file = $files[$count];
  $target_bits = file_get_contents($target_file);
  $array_target_bits = str_split($target_bits);

  $parity = 0;

  for($strcount = 0 ; $strcount < 20 ; $strcount++) {
    //echo $search_bits[$strcount] . " " . $target_bits[$strcount] . "\n"; 
    if($search_bits[$strcount] xor $target_bits[$strcount]) {
      //echo $search_bits[$strcount] . " XOR " . $target_bits[$strcount] . " is TRUE" . "\n";
      $parity++;
    } else {
      //echo $search_bits[$strcount] . " XOR " . $target_bits[$strcount] . " is FALSE" . "\n";
    }
  }
  if($parity < 4) {
      //$array_results += array("image_id" => basename($target_file, ".txt"), "parity" => $parity);
      echo basename($search_target, ".txt") . " and " . basename($target_file, ".txt") . " parity is " . $parity . "\n";
  }
}
?>
