<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <html lang="ja">
    <title>mission_5-1</title>
</head>
<body>
<?php

    //table
    $sql = "CREATE TABLE IF NOT EXISTS naha34"
        ." ("
	    . "id INT AUTO_INCREMENT PRIMARY KEY,"
	    . "name char(32) not null,"
        . "comment TEXT not null,"
        . "date TEXT,"
	    . "pass char(32) not null "
	    .");";
        $stmt = $pdo->query($sql);

    if(isset($_POST["name"])&& isset($_POST["comment"])&& isset($_POST["pass"])){
    //新規か編集か//
    if(empty($_POST["editor"])){
        $sql = $pdo -> prepare("INSERT INTO naha34 (name, comment, date, pass) 
        VALUES (:name, :comment, :date, :pass)");
         $sql -> bindParam(':name', $name, PDO::PARAM_STR);
         $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
         $sql -> bindParam(':date', $date, PDO::PARAM_STR);
         $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
      
    //各種データを受取
    $name=$_POST["name"];
    $comment=$_POST["comment"];
    $pass=$_POST["pass"];
    $date=date("Y/m/d H:i:s");
    $sql -> execute();
    
    }else{
    //編集番号が入力されているとき
        $sql = 'SELECT * FROM naha34'; 
        $stmt = $pdo->query($sql); 
        $results = $stmt->fetchAll(); 
        foreach ($results as $ko) {
            if($_POST["editor"]==$ko['id'] && $_POST["epass"]==$ko['pass']){
                $id = $_POST["editor"]; 
                //変更点    
                    $name = $_POST["name"];
                    $comment = $_POST["comment"]; 
                    $date = date("Y/m/d h:i:s");
                    $pass = $_POST["pass"];
                    $sql = 'UPDATE naha34 SET name=:name,comment=:comment,date=:date,pass=:pass WHERE id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
                    $stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
    }}}}


    
    //削除
    if(!empty($_POST["deleteNo"])&& !empty($_POST["password2"])){
        $sql = 'SELECT * FROM naha34'; 
        $stmt = $pdo->query($sql); 
        $results = $stmt->fetchAll(); 
        foreach ($results as $ko) {
        if($_POST["deleteNo"]==$ko['id'] && $_POST["password2"]==$ko['pass']){
        $id = $_POST["deleteNo"]; //削除したい投稿番号
        $sql = 'delete from naha34 where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }}}

    //編集番号
    if(!empty($_POST["edit1"])&& !empty($_POST["password3"])){
        $sql = 'SELECT * FROM naha34'; //sql文作成
        $stmt = $pdo->query($sql); //sql文実行
        $results = $stmt->fetchAll();
        //ループ
        foreach ($results as $ko) {
            if($_POST["edit1"]==$ko['id'] && $_POST["password3"]==$ko['pass']){
            
                $rename=$ko['name'];
                $recom=$ko['comment'];
                $renum=$ko['id'];
            }
        }
    }?>







<!--投稿フォーム-->
<form action="" method="post">
        <input type="name" name="name" placeholder="名前" 
        value="<?php if(isset($rename)){echo $rename;}?>"><br>
        <input type="comment" name="comment" placeholder="コメント"
        value="<?php if(isset($recom)){echo $recom;}?>"><br>
        <input type="text" name="editor" placeholder="編集番号" 
        value="<?php if(isset($renum)){echo $renum;}?>"><br>
        <input type="text" name="pass" placeholder="パスワード"><br>
        <input type="submit" name="submit" value="送信"><br>
    </form>
    <!--削除フォーム-->
    <form action="" method="post">
        <input type="number" name="deleteNo" placeholder="削除番号">
        <input type="text" name="password2" placeholder="パスワード7">
        <input type="submit" name="deleteb" value="削除">
    </form>
    <!--編集フォーム-->
    <form action="" method="post">
        <input type="number" name="edit1" placeholder="編集番号">
        <input type="text" name="password3" placeholder="パスワード">
        <input type="submit" name="edit2" value="編集">
    </form>
    
    <?php
    //表示
    $sql = 'SELECT * FROM naha34'; //sql文作成
    $stmt = $pdo->query($sql); //sql文実行
    $results = $stmt->fetchAll(); //実行結果を配列で取り出せるように
    foreach ($results as $ko){
        //$rowの中にはテーブルのカラム名が入る
        echo $ko['id'].' | ';
        echo $ko['name'].' | ';
        echo $ko['comment'].' |';
        echo $ko['date'].'<br>';
    echo "<hr>";}
?>

</body>
</html>