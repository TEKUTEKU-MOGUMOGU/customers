<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href="kigyoudesign.css">
    <title>Bought</title>
    </head>
    <body>
        <?php
            $dsn = 'mysql:dbname=tb220376db;host=localhost';
            $user = 'tb-220376';
            $password = '7A3JpFgm5s';
            $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


            $sql = "SELECT*FROM cart1";
            $stmt = $pdo->query($sql);
            $results1 = $stmt->fetchAll();
            foreach($results1 as $row){
                //cart1の変数定義
                $buysirialno = $row['buysirialno'];
                $buynumber = $row['buynumber'];
                
                $sql = "SELECT*FROM eeee ORDER BY sirialno ASC";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach($results as $row){
                    //eeeeの変数定義
                    $sirialno = $row['sirialno'];
                    $number = $row['number']; 
                }

                    //商品数-購入量=$newnumber（購入後、残りの商品数）
                    $newnumber = $number - $buynumber;
                    //eeee内の商品数を編集
                    $sql = 'UPDATE eeee SET number = :number WHERE sirialno = :sirialno';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':number', $newnumber, PDO::PARAM_STR);
                    $stmt->bindParam(':sirialno', $buysirialno, PDO::PARAM_INT);
                    $stmt->execute();                 
            }
            $sql = "DELETE FROM eeee WHERE number = 0";
            $stmt = $pdo->query($sql);
            $sql = "DELETE FROM cart1";
            $stmt = $pdo->query($sql); 

        ?>
        <h1>購入が完了しました！</h1>
        <input type="button" value="地域検索へ戻る" id="return">
        <!-- リスト確認用に、ひとまず"kigyoumypage.php"へもどる-->
        <script>
            document.getElementById('return').onclick=function(){
                location.href = 'kigyoumypage.php';
            };
        </script>
    </body>
</html>