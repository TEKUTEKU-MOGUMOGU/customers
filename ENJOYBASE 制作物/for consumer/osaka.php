<?php
    $dsn = 'mysql:dbname=tb220376db;host=localhost';
    $user = 'tb-220376';
    $password = '7A3JpFgm5s';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = 'SELECT * FROM img WHERE id=(SELECT max(id) from img)';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //最新の登録画像を変数に格納
        $img_name = $row['img'];   
        
        //同時に店舗情報を登録しているDBにアクセスし最新のデータを取得
        $sql = 'SELECT * FROM shopinfo WHERE station like "%大阪%"';
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
