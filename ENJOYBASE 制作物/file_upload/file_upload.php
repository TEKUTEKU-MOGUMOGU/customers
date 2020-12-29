<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>お店情報登録</h2>
<form enctype="multipart/form-data" action="kigyoumypage.php" method="POST">
      <div class="file-up">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input name="img" type="file" accept="image/*" />
      </div>
      <div>
        <textarea
          name="caption"
          placeholder="キャプション（140文字以下）"
          id="caption"
        ></textarea>
      </div>
      <div class="submit">
        <input type="submit" value="送信" class="btn" />
      </div>
</form>
<form method ="post" action="">
            <table border="1">
                <tbody>
                    <tr>
                        <td style="background-color: #1B4353;" width="150" align="center">
                            <font color="#ffffff"><strong>店舗名</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200">
                            <input type="text" name="name" size="70"></td>
                    </tr>
                    <tr>
                        <td style="background-color: #1B4353;" width="150" align="center">
                            <font color="#ffffff"><strong>住所</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200">
                            <input type="text" name="adress" size="70"></td>
                    </tr>
                    <tr>
                        <td style="background-color: #1B4353;" width="150" align="center">
                            <font color="#ffffff"><strong>最寄り駅</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200">
                            <input type="text" name="station" size="70"></td>
                    </tr>
                    <tr>
                        <td style="background-color: #1B4353;" width="150" align="center">
                            <font color="#ffffff"><strong>営業時間</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200">
                            <input type="text" name="time" size="70"></td>
                    </tr>
                    <tr>
                        <td style="background-color: #1B4353;" width="150" align="center">
                            <font color="#ffffff"><strong>電話番号</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200">
                            <input type="tel" name="phone" size="70"></td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" name="submit" value="お店情報登録" class="btn-gradient-radiu"><br>
</from>
<?php
    //DB接続
    $dsn = 'mysql:dbname=tb220376db;host=localhost';
    $user = 'tb-220376';
    $password = '7A3JpFgm5s';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS shopinfo"
	    ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
	      . "adress char(255),"
        . "station char(255),"
        . "time char(255),"
	      . "phone varchar(255)"
	      .");";
	$stmt = $pdo->query($sql);
	$sql = $pdo -> prepare("INSERT INTO shopinfo (name, adress, station, time, phone) 
    VALUES (:name, :adress, :station, :time, :phone)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':adress', $adress, PDO::PARAM_STR);
    $sql -> bindParam(':station', $station, PDO::PARAM_STR);
	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql -> bindParam(':phone', $phone, PDO::PARAM_STR);
    if(empty($_POST["name"])==false && empty($_POST["adress"])==false &&
    empty($_POST["station"])==false && empty($_POST["time"])==false && 
    empty($_POST["phone"])==false){
          $name = $_POST["name"];
          $adress = $_POST["adress"];
          $station = $_POST["station"];
          $time = $_POST["time"];
	        $phone = $_POST["phone"];
          $sql -> execute();
    }  
?>
</body>
</html>