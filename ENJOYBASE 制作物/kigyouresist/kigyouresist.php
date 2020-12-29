<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <title>FOOD</title>
</head>
<body>
<p id="timer">あと<span id="day"></span>日<span id="hour"></span>時間<span id="min"></span>分<span id="sec"></span>秒</p>
    <form method ="post" action="" name="form0">
        <table border="1">
            <tbody>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>商品番号</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="100">
                        <input type="number" name="sirialno" size="70"></td>
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>商品名</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="100">
                        <input type="text" name="goods" size="20"></td>
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>数量</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="100">
                        <input type="number" name="number" size="70"></td>
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>料金</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="100">
                        <input type="number" name="price" size="70"></td>
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>期限</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="100">
                    <input type="datetime-local" name="date" size="70"></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="submit" value="登録" onClick="return check()">
    </from>
<?php
    $dsn = 'mysql:dbname=tb220376db;host=localhost';
    $user = 'tb-220376';
    $password = '7A3JpFgm5s';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS eeee"
	    ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "sirialno INT(5),"
	    . "name char(32),"
        . "number INT(3),"
        . "price INT(5),"
	    . "date datetime"
	    .");";
	$stmt = $pdo->query($sql);
    $sql = $pdo -> prepare("INSERT INTO eeee (sirialno, name, number, price, date) VALUES (:sirialno, :name, :number, :price, :date)");
    $sql -> bindParam(':sirialno', $sirialno, PDO::PARAM_STR);
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':number', $number, PDO::PARAM_STR);
    $sql -> bindParam(':price', $price, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	if(empty($_POST["sirialno"])==false && empty($_POST["goods"])==false && empty($_POST["number"])==false && empty($_POST["price"])==false && empty($_POST["date"])==false){
        $sirialno = $_POST["sirialno"];
        $name = $_POST["goods"];
        $number = $_POST["number"];
        $price = $_POST["price"];
        $time = strtotime($_POST["date"]);
        $time2 = strtotime('now');
        $result = ($time-$time2)/(60*60*24);
        if($result>0 && $number>0 && $sirialno>0 && $price>0){
            $date = $_POST["date"];
            $sql -> execute();
            echo "登録完了！";
            /*$sql = 'SELECT * FROM ee';
	        $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            date_default_timezone_set("Asia/Tokyo");
            foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['number'].',';
                $time = strtotime($row['date']);
                $time2 = strtotime('now');
                $result = ($time-$time2)/(60*60*24);
                $datetime = new DateTime($row['date']);
                $current  = new DateTime();
                $diff     = $current->diff($datetime);
                if($result<=0){
                    echo "期限切れです。削除して下さい。";
                    echo "<hr>";
                }else{
                    printf('残り %d日 %d時間%d分',
                    $diff->days, $diff->h,$diff->i).'<br>';
                    echo "<hr>";
                }
            }*/
        }else if($result<=0){
            echo "<font color=\"RED\">現在時刻より先の時刻を入力して下さい。</font>";
        }else if($sirialno<=0){
            echo "<font color=\"RED\">商品番号は正の整数を入力して下さい。</font>";
        }else if($price<=0){
            echo "<font color=\"RED\">価格設定は正の整数を入力して下さい。</font>";
        }else{
            echo "<font color=\"RED\">数量は正の整数を入力して下さい。</font>";
        }    
    }
    ?>
    <form method ="post" action="" name="form1">
        <table border="1">
            <tbody>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>削除したい商品番号</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="200">
                        <input type="number" name="delnum"></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="submit" value="削除">
    </from>
    <?php
    if(empty($_POST["delnum"])==false){
        $delnum = $_POST["delnum"];
        $sql = 'SELECT * FROM eeee';
        $stmt = $pdo->query($sql);
        $stmt->execute();
        $count1=$stmt->rowCount();
        $sql = 'delete from eeee where sirialno=:sirialno';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':sirialno', $delnum, PDO::PARAM_INT);
        $stmt->execute();
        $sql = 'SELECT * FROM eeee';
        $stmt = $pdo->query($sql);
        $stmt->execute();
        $count2=$stmt->rowCount();
        if($count1>$count2){
            echo "削除しました！";
        }else{
            echo "<font color=\"RED\">入力された商品番号が見つかりません。</font>";
        }
    }   
        
        /*$sql = 'SELECT * FROM ee';
	    $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        date_default_timezone_set("Asia/Tokyo");
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['number'].',';
            $datetime = new DateTime($row['date']);
            $current  = new DateTime();
            $diff     = $current->diff($datetime);
            printf('残り %d日 %d時間%d分',
                $diff->days, $diff->h,$diff->i).'<br>';
            echo "<hr>";
        }*/
?>
<form method ="post" action="" name="form2">
        <table border="1">
            <tbody>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>変更したい商品番号</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="200">
                    <input type="number" name="edit"></td>
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>変更後の数量</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="200">
                    <input type="number" name="editnum"></td>
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>変更後の価格</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="200">
                    <input type="number" name="editprice"></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="submit" value="編集">
    </from>
<?php    
    if(empty($_POST["edit"])==false && empty($_POST["editnum"])==false && empty($_POST["editprice"])==false){
            $id = $_POST["edit"]; //変更する投稿番号
            $edit = $_POST["editnum"];
            $editprice = $_POST["editprice"];
            $sql = 'SELECT * FROM eeee';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
            $num1 = 0;
            $price1 = 0;
            //編集前の数量の合計
            foreach ($results as $row){
                $num1 = $num1 + $row['number'];
                $price1 = $price1 + $row['price'];   
            }
            //編集開始
            $sql = 'UPDATE eeee SET number=:number,price=:price WHERE sirialno=:sirialno';
	        $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':number', $edit, PDO::PARAM_STR);
            $stmt->bindParam(':price', $editprice, PDO::PARAM_STR);
	        $stmt->bindParam(':sirialno', $id, PDO::PARAM_INT);
            $stmt->execute();
            //編集終了
            $sql = 'SELECT * FROM eeee';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
            $num2 = 0;
            $price2 =0;
            //編集後の数量の合計
            foreach ($results as $row){
                $num2 = $num2 + $row['number']; 
                $price2 = $price2 + $row['price'];  
            }
            if($num1==$num2 && $price1==$price2){
                echo "<font color=\"RED\">入力された商品番号がないかデータに変更はありませんでした。</font>";
            }else if($price1==$price2 && $num1!==$num2){
                echo "数量のみを変更しました！";
            }else if($price1!==$price2 && $num1==$num2){
                echo "料金のみを変更しました！";
            }else{
                echo "変更完了！";
            }
    }    
	        /*$sql = 'SELECT * FROM ee';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
		        //$rowの中にはテーブルのカラム名が入る
		        echo $row['id'].',';
		        echo $row['name'].',';
		        echo $row['number'].',';
            $datetime = new DateTime($row['date']);
            $current  = new DateTime();
            $diff     = $current->diff($datetime);
            printf('残り %d日 %d時間%d分',
                $diff->days, $diff->h,$diff->i).'<br>';
            echo "<hr>";
	        }*/  
        
?>    
    <form method ="post" action="">
        <table border="1">
            <tbody>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>本日の受け渡し希望時間</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="200">
                    <input type="time" min="08:00" max="23:00" name="time"></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="submit" value="設定">
        <br>
    </from>

<?php
    $sql = $pdo -> prepare("INSERT INTO time (name) VALUES (:name)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	if(empty($_POST["time"])==false){
        $name = $_POST["time"];
        $sql -> execute();
    }
?>     
    <script type="text/javascript" src="kigyoujavascript.js"></script>
</body>
</html>
