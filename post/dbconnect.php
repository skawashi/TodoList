<?php
try{
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
        PDO::ATTR_EMULATE_PREPARES => false
    );
    $db = new PDO('mysql:dbname=todolist; host=localhost;charset=utf8', 'root', 'root', $opt);
} catch(PDOException $e) {
    echo 'DB接続エラー : ' . $e->getMessage();
}
?>