<?php
session_start();

// $_SESSION = array();
// if(ini_get('session.use_cookies')) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
// }
// session_destroy();
// setcookie("PHPSESSID", '', time() - 42000, '/');

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