<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="kigyoudesign.css">
    <title>Confirm</title>
</head>
<body>
<?php
    $dsn = 'mysql:dbname=tb220376db;host=localhost';
    $user = 'tb-220376';
    $password = '7A3JpFgm5s';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>    
    <h1>ご注文商品</h1>
<?php
$sql = 'SELECT * FROM cart1 ORDER BY buysirialno ASC';
	    $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        date_default_timezone_set("Asia/Tokyo");
        if(empty($results)){
            echo "カートに商品が入っておりません";
        }else{
            foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
                $time = strtotime($row['date']);
                $time2 = strtotime('now');
                $result = ($time-$time2)/(60*60*24);
                $datetime = new DateTime($row['date']);
                $current  = new DateTime();
                $diff     = $current->diff($datetime);
                if($result<=0){
                    $delnum = $row['buysirialno'];
                    $sql = 'delete from cart1 where buysirialno=:buysirialno';
	                $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':buysirialno', $delnum, PDO::PARAM_INT);
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
                                    <font color="#ffffff"><strong>数量</strong></td>
                                <td style="background-color: #1B4353;" width="150">
                                    <font color="#ffffff"><strong>料金</strong></td>    
                                <td style="background-color: #1B4353;" width="250">
                                    <font color="#ffffff"><strong>期限</strong></td>        
                            </tr>
                            <tr>
                                <td style="background-color:rgb(248,248,248);" width="150" align="center">
                                    <?php echo $row['buysirialno'];?></td>
                                <td style="background-color:rgb(248,248,248);" width="150">
                                    <?php echo $row['name'];?></td>
                                <td style="background-color:rgb(248,248,248);" width="150">
                                    <?php echo $row['buynumber'];?></td>
                                <td style="background-color:rgb(248,248,248);" width="150">
                                    <?php echo $row['price'];?>円</td>
                                <td style="background-color:rgb(248,248,248);" width="150">
                                    <?php printf('残り %d日 %d時間%d分',
                                        $diff->days, $diff->h,$diff->i);?></td>    
                            </tr>
                        </tbody>
                    </table> 
                </div>
                <h2>これでお間違いないですか？</h2><br>
            <form method="post" action=""> 
                <input type="submit" value="はい" name="yes" id="yes">
                <input type="submit" value="選びなおす" name="no" id="no">
            </form>            
            <?php

            if(isset($_POST['no'])){
                $sql = "DELETE FROM cart1";
                $stmt = $pdo->query($sql);
                header('location:kigyoumypage.php');
            }
                        }
                    }    
                }

            if(isset($_POST['yes'])){
                //bought.phpの16-46行目を入れる場合、ここに入る。
                header('location:bought.php');              
            }
            ?>


</body>
</html>