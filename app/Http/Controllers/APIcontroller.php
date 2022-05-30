<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class APIcontroller extends Controller
{
  public function index(Request $request) 
  {
    $w = 4;
    $h = 5;

    //$search_bits = Storage::disk('public')->get('outputs/037nao0184_0_b.txt');
    $directory_path = 'cache';
    $request->file('card_img')->storeAs('public/' . $directory_path , 'cache_img.png'); 

    $image_path = Storage::url('public/cache/cache_img.png');

    $image = imagecreatefrompng("." . $image_path);
    //return response($image_file, 200)->header('Content-Type', 'image/png');
    //$image = imagecreatefrompng($image_file);

    //Storage::delete('public/cache/cache_img.png');

    // $image
    $canvas = imagecreatetruecolor($w, $h);
    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $w, $h, 640, 800);

    imagefilter ( $canvas , IMG_FILTER_EDGEDETECT );
    imagefilter ( $canvas , IMG_FILTER_GRAYSCALE );
    imagefilter ( $canvas , IMG_FILTER_SMOOTH , 100 );
    imagefilter ( $canvas , IMG_FILTER_BRIGHTNESS , 20 );
    imagefilter ( $canvas , IMG_FILTER_CONTRAST , -255 );

    $resize_path = (storage_path('app/public/cache/') . $w . "x" . $h . "_cache_img.png");
    imagepng($canvas, $resize_path);
    Storage::delete('public/cache/cache_img.png');

    $search_bits = "";
    //画像データ符号化
    //
    for($countY = 0 ; $countY < $h ; $countY++) {
      for($countX = 0 ; $countX < $w ; $countX++) {

        //座標の色取得
        $rgb = imagecolorat($canvas, $countX, $countY);
        $colors = imagecolorsforindex($canvas, $rgb);

        if($rgb != 0) {
          $search_bits = $search_bits . "1";
        } else {
          $search_bits = $search_bits . "0";
        }
      }
    }

    Storage::delete('public/cache/4x5_cache_img.png');
    $array_search_bits = str_split($search_bits);

    $files = glob(storage_path('app/public/outputs/') . "*.txt");
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
        echo $search_bits . " and " . basename($target_file, ".txt") . " parity is " . $parity . "\n";
        echo "\n";
        //echo basename($target_file, ".txt");
      }
    }
    return;
  } 
}
