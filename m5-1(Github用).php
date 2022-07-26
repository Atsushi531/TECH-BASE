<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>mission-5-1</title>
</head>
<body>
    <!-- データベース接続 -->
    <?php
        $dsn = 'データベース名';
        $user = 'ユーザ名';
        $password = 'パスワード名';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    ?>

    <!-- 入力フォーム -->
    <form action="" method="post">

        <!-- 名前入力フォーム -->
        <input type="name" name="name" placeholder="名前を入力" value=
            "<?php
                if(!empty($_POST["editid"]))
                {
                    $edit = $_POST["editid"];
                    $pass = $_POST["pass3"];
                    $sql = 'SELECT * FROM techbase';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row)
                    {
                        if($row['id']==$edit && $row['pass']==$pass)
                        {
                            echo $row['name'];
                            break;
                        }
                        else
                        {
                            
                        }
                    }
                }
            ?>"
        ><br>
        
        <!-- コメント入力フォーム -->
        <input type="text" name="comment" placeholder="コメントを入力" value=
            "<?php
                if(!empty($_POST["editid"]))
                {
                    $edit = $_POST["editid"];
                    $pass = $_POST["pass3"];
                    $sql = 'SELECT * FROM techbase';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row)
                    {
                        if($row['id']==$edit && $row['pass']==$pass)
                        {
                            echo $row['comment'];
                            break;
                        }
                        else
                        {
                            
                        }
                    }
                }
            ?>"
        ><br>
        
        <!-- パスワード入力フォーム -->
        <input type="password" name="pass" placeholder="パスワードを入力" value=
            "<?php
                if(!empty($_POST["editid"]))
                {
                    $edit = $_POST["editid"];
                    $pass = $_POST["pass3"];
                    $sql = 'SELECT * FROM techbase';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row)
                    {
                        if($row['id']==$edit && $row['pass']==$pass)
                        {
                            echo $row['pass'];
                            break;
                        }
                        else
                        {
                            
                        }
                    }
                }
            ?>"
        >
        <input type="submit" name="submit" value="送信">
        
        <!-- 編集機能隠しフォーム -->
        <input type="hidden" name="edit" value=
            "<?php if(!empty($_POST["editid"]) && !empty($_POST["pass3"]))
                {
                    $edit = $_POST["editid"];
                    $pass = $_POST["pass3"];
                    $sql = 'SELECT * FROM techbase';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    foreach ($results as $row)
                    {
                        if($row['id']==$edit && $row['pass']==$pass)
                        {
                            echo $edit;
                            break;
                        }
                        else
                        {
                            
                        }
                    }
                } 
            ?>"
        >
    </form><br>
    
    <!-- 削除入力フォーム -->
    <form action="" method="post">
        <input type="number" name="deleteid" placeholder="削除番号を入力"><br>
        <input type="password" name="pass2" placeholder="パスワードを入力">
        <input type="submit" name="delsubmit" value="削除">
    </form><br>
    
    <!-- 編集入力フォーム -->
    <form action="" method="post">
        <input type="number" name="editid" placeholder="編集番号を入力"><br>
        <input type="password" name="pass3" placeholder="パスワードを入力">
        <input type="submit" name="editsubmit" value="編集">
    </form><br>

    <?php
        //テーブル作成
        $sql = "CREATE TABLE IF NOT EXISTS techbase"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "date DATETIME,"
        . "pass varchar(30)"
        .");";
        $stmt = $pdo->query($sql);

        // 投稿機能
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["edit"]) && !empty($_POST["pass"]))
        {
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $date=date("Y/m/d H:i:s");
            $pass=$_POST["pass"];
            
            $sql = $pdo -> prepare("INSERT INTO techbase (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
            $sql -> bindParam(":name", $name, PDO::PARAM_STR);
            $sql -> bindParam(":comment", $comment, PDO::PARAM_STR);
            $sql -> bindParam(":date", $date, PDO::PARAM_STR);
            $sql -> bindParam(":pass", $pass, PDO::PARAM_STR);
            $sql -> execute();
        }

        //削除機能
        if(!empty($_POST["deleteid"]) && !empty($_POST["pass2"]))
        {
            $deleteid=$_POST["deleteid"];
            $pass=$_POST["pass2"];
            $id=$deleteid;
            
            $sql = 'delete from techbase where id=:id and pass=:pass';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->execute();
        }
        
        //編集機能
        if(!empty($_POST["edit"]))
        {
            $editid=$_POST["edit"];
            $editname=$_POST["name"];
            $editcomment=$_POST["comment"];
            $editdate=date("Y/m/d H:i:s");
            $pass=$_POST["pass"];
            $id=$editid;

            $sql = 'UPDATE techbase SET name=:name,comment=:comment,date=:date, pass=:pass WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $editname, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $editcomment, PDO::PARAM_STR);
            $stmt->bindParam(':date', $editdate, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->execute();
        }

        //ブラウザ表示機能
        $sql = 'SELECT * FROM techbase';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row)
        {
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].'<br>';
            echo "<hr>";
        }

    ?>
</body>
</html>
