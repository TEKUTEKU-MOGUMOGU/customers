
<?php
    $dsn = 'mysql:dbname=tb220376db;host=localhost';
    $user = 'tb-220376';
    $password = '7A3JpFgm5s';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	$sql = $pdo -> prepare("INSERT INTO store (name, adress, time, email, password) 
    VALUES (:name, :adress, :time, :email, :password)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':adress', $adress, PDO::PARAM_STR);
    $sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql -> bindParam(':email', $email, PDO::PARAM_STR);
	$sql -> bindParam(':password', $password, PDO::PARAM_STR);
    if(empty($_POST["name"])==false && empty($_POST["adress"])==false &&
    empty($_POST["time"])==false && empty($_POST["mail"])==false && 
    empty($_POST["pass"])==false && empty($_POST["passcon"])==false){
        if($_POST["pass"]!== $_POST["passcon"]){
            echo "パスワードが一致しません。";
        }else{
            $name = $_POST["name"];
            $adress = $_POST["adress"];
            $time = $_POST["time"];
            $email = $_POST["mail"];
	        $password = $_POST["pass"];
	        $sql -> execute();
	        $sql = 'SELECT * FROM store';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['adress'].',';
                echo $row['time'].',';
                echo $row['email'].',';
                echo $row['password'].'<br>';
                echo "<hr>";
            }
        }    
    }
    $delnum = 15;
    $sql = 'delete from store where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $delnum, PDO::PARAM_INT);
    $stmt->execute();
?>