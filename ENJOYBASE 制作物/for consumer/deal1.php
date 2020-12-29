<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="kigyoudesign.css">
    <title>FOOD</title>
</head>
<body>
<?php
    $dsn = 'mysql:dbname=tb220376db;host=localhost';
    $user = 'tb-220376';
    $password = '7A3JpFgm5s';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>    
    <h1>レスキューフード一覧</h1>
            <p>本日は
        <?php
            $sql = 'SELECT * FROM time WHERE id=(SELECT max(id) from time)';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){   
                echo $row['name'];
            }
        ?>
        頃お店が空いています。</p>
<?php         
    //ファイルの受け取り
    if(empty($_POST["caption"])==false){
        $comment = $_POST["caption"];
        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];
        $file_err = $file['error'];
        $filesize = $file['size'];
        $upload_dir = 'img';
        $save_filename = date('YmdHis').$filename;
        //保存される名前を作成
        $name ='img'.$save_filename;
        $sql = $pdo -> prepare("INSERT INTO img (img, comment) VALUES (:img, :comment)");
        $sql -> bindParam(':img', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> execute();
        //キャプションを取得
        $caption = filter_input(INPUT_POST, 'caption',
            FILTER_SANITIZE_SPECIAL_CHARS);
    
        //キャプションのバリデーション
        //未入力
        if(empty($caption)){
            echo 'キャプションを入力して下さい。';
            echo '<br>';
        }
        //140文字以内か
        if(strlen($caption) > 140){
            echo 'キャプションを140文字以内で入力して下さい。';
            echo '<br>';
        }
        //ファイルのバリデーション
        //ファイルサイズが1MB未満か
        if($filesize > 1048576 || $file_err == 2){
            echo 'ファイルサイズは1MB未満にして下さい。';
            echo '<br>';
        }
        //拡張は画像形式か
        $allow_ext = array('jpg','jpeg','png');
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array(strtolower($file_ext),$allow_ext)){
            echo '画像ファイルを添付して下さい。';
            echo '<br>';
        }
        //ファイルはあるか？
        if(is_uploaded_file($tmp_path)){
            if(move_uploaded_file($tmp_path,$upload_dir.$save_filename)){
                echo $filename.'をアップしました。';
                echo '<br>';
            }else{
                echo 'ファイルが保存できませんでした。';
                echo '<br>';
            }
        }else{
            echo 'ファイルが選択されていません。';
            echo '<br>';
        }
    }
    //店舗画像を登録しているDBにアクセスし最新のデータを取得
    $sql = 'SELECT * FROM img WHERE id=(SELECT max(id) from img)';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //最新の登録画像を変数に格納
        $img_name = $row['img'];   
        
        //同時に店舗情報を登録しているDBにアクセスし最新のデータを取得
        $sql = 'SELECT * FROM shopinfo WHERE id=(SELECT max(id) from shopinfo)';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $stnum = substr($row['phone'],0,3);
            $midnum = substr($row['phone'],3,4);
            $finnum = substr($row['phone'],7,4);
            ?>  
            <div class="storeinfo">
            <table border="1">
            <tbody>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>店舗写真</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="150" align="center">
                        <?php echo "<img src=\"$img_name\">";?></td>        
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>店舗名</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="150" align="center">
                        <?php echo $row['name'];?></td>        
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>住所</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200" align="center">
                        <?php echo $row['adress'];?></td>        
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>最寄り駅</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200" align="center">
                        <?php echo $row['station'];?></td>        
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>営業時間</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200" align="center">
                        <?php echo $row['time'];?></td>        
                </tr>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>電話番号</strong></td>
                        <td style="background-color:rgb(248,248,248);" width="200" align="center">
                        <?php echo $stnum."-".$midnum."-".$finnum; ?></td>        
                </tr>
            </tbody>
        </table> 
        </div>     
<?php
    //1つ目のforeach閉じる
            }
    //2つ目のforeach閉じる
        }     
?>   
<?php      
    $sql = 'SELECT * FROM eeee ORDER BY sirialno ASC';
	$stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    date_default_timezone_set("Asia/Tokyo");
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        $time = strtotime($row['date']);
        $time2 = strtotime('now');
        $result = ($time-$time2)/(60*60*24);
        $datetime = new DateTime($row['date']);
        $current  = new DateTime();
        $diff     = $current->diff($datetime);
        if($result<=0){
            $delnum = $row['sirialno'];
            $sql = 'delete from eeee where sirialno=:sirialno';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':sirialno', $delnum, PDO::PARAM_INT);
            $stmt->execute();
        }else{
?>
    <div class="productinfo">
        <table border="1">
            <tbody>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>No.</strong></td>
                    <td style="background-color: #1B4353;" width="150">
                        <font color="#ffffff"><strong>商品名</strong></td>
                    <td style="background-color: #1B4353;" width="150">
                        <font color="#ffffff"><strong>料金</strong></td>    
                    <td style="background-color: #1B4353;" width="250">
                        <font color="#ffffff"><strong>期限</strong></td>
                        <td style="background-color: #1B4353;" width="250">
                        <font color="#ffffff"><strong>個数</strong></td>        
                </tr>
                <tr>
                    <td style="background-color:rgb(248,248,248);" width="150" align="center">
                        <?php echo $row['sirialno'];?></td>
                    <td style="background-color:rgb(248,248,248);" width="150">
                        <?php echo $row['name'];?></td>
                    <td style="background-color:rgb(248,248,248);" width="150">
                        <?php echo $row['price'];?>円</td>
                    <td style="background-color:rgb(248,248,248);" width="150">
                        <?php printf('残り %d日 %d時間%d分',
                            $diff->days, $diff->h,$diff->i);?></td> 
                    <td style="background-color:rgb(248,248,248);" width="150">                      
                        <?php echo $row['number']; ?></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div id = "deal">
        <form action="" method="post">
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
                        <font color="#ffffff"><strong>数量</strong></td>
                    <td style="background-color:rgb(248,248,248);" width="100">
                        <input type="number" name="number" size="70"></td>
                </tr> 
            </tbody>
        </table>                                   
        <input type="submit" value="カートに入れる">

        </form> 
        </div>      
<?php
        }
    }

    if(!empty($_POST['sirialno'])&&!empty($_POST['number'])){
        $sirialno = $_POST['sirialno'];
        $number = $_POST['number'];

        if($sirialno > 0 && $number > 0){
            $sql = 'SELECT * FROM eeee where sirialno = :sirialno';
            $stmt = $pdo->query($sql);
            $stmt->bindParam(':sirialno', $sirialno, PDO::PARAM_INT);
            $results = $stmt->fetchAll();
            date_default_timezone_set("Asia/Tokyo");
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        $time = strtotime($row['date']);
        $time2 = strtotime('now');
        $result = ($time-$time2)/(60*60*24);
        $datetime = new DateTime($row['date']);
        $current  = new DateTime();
        $diff     = $current->diff($datetime);
        if($result<=0){
            $delnum = $row['sirialno'];
            $sql = 'delete from eeee where sirialno=:sirialno';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':sirialno', $delnum, PDO::PARAM_INT);
            $stmt->execute();
        }else{
            ?>
            <table border="1">
            <tbody>
                <tr>
                    <td style="background-color: #1B4353;" width="150" align="center">
                        <font color="#ffffff"><strong>No.</strong></td>
                    <td style="background-color: #1B4353;" width="150">
                        <font color="#ffffff"><strong>商品名</strong></td>
                    <td style="background-color: #1B4353;" width="150">
                        <font color="#ffffff"><strong>料金</strong></td>    
                    <td style="background-color: #1B4353;" width="250">
                        <font color="#ffffff"><strong>期限</strong></td>
                        <td style="background-color: #1B4353;" width="250">
                        <font color="#ffffff"><strong>個数</strong></td>        
                </tr>
                <tr>
                    <td style="background-color:rgb(248,248,248);" width="150" align="center">
                        <?php echo $row['sirialno'];?></td>
                    <td style="background-color:rgb(248,248,248);" width="150">
                        <?php echo $row['name'];?></td>
                    <td style="background-color:rgb(248,248,248);" width="150">
                        <?php echo $row['price'];?>円</td>
                    <td style="background-color:rgb(248,248,248);" width="150">
                        <?php printf('残り %d日 %d時間%d分',
                            $diff->days, $diff->h,$diff->i);?></td> 
                    <td style="background-color:rgb(248,248,248);" width="150">                      
                        <?php echo $row['number']; ?></td>
                </tr>
            </tbody>
        </table>
        <?php
        }    
    }
        }
    }
        
        
?>   
        <!--      
        <main>
            <div class="input__area">
                <img id="image-preview" src="img/noimage.jpg">
                <label class="input-button">
                    <input id="image" type="file"/>
                </label>
            </div>
        </main>
        --> 
<!-- 
        <table>
	<tr><td colspan="3" id="msg_box" style="height:45px;"></td></tr>
 
	<tr><td><img border="0" id="pic11" src="img/slot7.png" width="90" height="60" alt="写真11" ></td>
    	    <td><img border="0" id="pic12" src="img/slotcherry.png" width="90" height="60" alt="写真12" ></td>
    	    <td><img border="0" id="pic13" src="img/slotjac.png" width="90" height="60" alt="写真13" ></td></tr>
 
	<tr><td><img border="0" id="pic21" src="img/slotkane.png" width="90" height="60" alt="写真21" ></td>
    	    <td><img border="0" id="pic22" src="img/slot7.png" width="90" height="60" alt="写真22" ></td>
    	    <td><img border="0" id="pic23" src="img/slotsuica.png" width="90" height="60" alt="写真23" ></td></tr>
 
	<tr><td><img border="0" id="pic31" src="img/slotjac.png" width="90" height="60" alt="写真31" ></td>
    	    <td><img border="0" id="pic32" src="img/slotbar.png" width="90" height="60" alt="写真32" ></td>
    	    <td><img border="0" id="pic33" src="img/slot7.png" width="90" height="60" alt="写真33" ></td></tr>
 
	<tr><td colspan="3" style="height:30px;"></td></tr>
 
 
    	<tr><td align="center">
    	<input type="button" value="停止" onClick="stop_prg(0)" style="width:80px; height:60px; font-size:22px;">
    	</td>
    	<td align="center">
    	<input type="button" value="停止" onClick="stop_prg(1)" style="width:80px; height:60px; font-size:22px;">
    	</td>
    	<td align="center">
    	<input type="button" value="停止" onClick="stop_prg(2)" style="width:80px; height:60px; font-size:22px;">
    	</td></tr>
 
	<tr><td colspan="3" style="height:15px;"></td></tr><tr><td colspan="3"></td></tr>
 
	<tr><td colspan="3">
    	<input type="button" value="スタート" onClick="start()" style="width:170px; height:60px; font-size:25px;">
    	</td></tr>
 
    </table>
    -->    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript" src="picture.js"></script>
        <script type="text/javascript" src="slot.js"></script>
</body>
</html>


　　　　 