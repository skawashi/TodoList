<?php
function hsc($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function islogin(){
    if(!isset($_SESSION['id'])) {
        // ログイン認証されていない場合
        return false;
    }

    if($_SESSION['expires'] < time()) {
        // ログイン認証をしていたが、タイムアウト時刻を過ぎている場合
        $_SESSION = array();
        session_destroy();
        return false;
    }
    // ログイン認証をし、タイムアウト時刻を過ぎていなかった場合
    $_SESSION['expires'] = time() + $_SESSION['timeout'];
    return true;
}
?>