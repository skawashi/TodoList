<?php
session_start();

// Todo CSRF対策のトークン生成を追加する

//セッションの初期化
$_SESSION = array();
//セッションクッキーを削除
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
    unset($_COOKIE[session_name()]);
}
//セッションを破壊
session_destroy();

header('Location: ./login.php');
exit();
?>