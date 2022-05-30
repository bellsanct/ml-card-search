<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
 <form action="api/search" method="POST" enctype="multipart/form-data">
 @csrf
 <input type="file" name="card_img">
 <input type="submit" value="send">
 </form>
</body>
</html>
