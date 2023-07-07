<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得
$id      = $_POST['id'];
$dialogue = $_POST['dialogue'];
$mangatitle = $_POST['mangatitle'];
// $img = $_POST['img'];
$author = $_POST['author'];
$source = $_POST['source'];
$comment = $_POST['comment'];

//2. DB接続します
//*** function化する！  *****************
try {
    $db_name = 'gs_db2';    //データベース名
    $db_id   = 'root';      //アカウント名
    $db_pw   = '';      //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

//３．データ登録SQL作成

// UPDATEテーブル名SETカラム1=1にいれたいもの

$stmt = $pdo->prepare('UPDATE manga_an_table2
                        SET dialogue = :dialogue,
                            mangatitle = :mangatitle,
                            author = :author,
                            comment = :comment,
                            source = :source,
                            indate = sysdate()
                        WHERE id = :id;');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':dialogue', $dialogue, PDO::PARAM_STR);//ストリングス「文字」
$stmt->bindValue(':mangatitle', $mangatitle, PDO::PARAM_STR);//ストリングス「文字」
$stmt->bindValue(':author', $author, PDO::PARAM_STR);//ストリングス「文字」
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);//ストリングス「文字」
$stmt->bindValue(':mangatitle', $mangatitle, PDO::PARAM_STR);//ストリングス「文字」
$stmt->bindValue(':source', $source, PDO::PARAM_STR);//ストリングス「文字」
$stmt->bindValue(':id', $id, PDO::PARAM_INT);//イント「数字」

$status = $stmt->execute(); //実行

$result = '';

//４．データ登録処理後
    //*** function化する！******\
    if ($status === false) {
        $error = $stmt->errorInfo();
        exit('SQLError:' . print_r($error, true));
    } else {
        header('Location: select.php');
        exit();
    }
        //*** function化する！*****************
    
    ?>