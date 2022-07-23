<?php
session_start();
require('./dbconnect.php');

// 入力内容のチェック
if(!empty($_POST)) {
    // 入力漏れがない場合
    if($_POST['mail'] != '' && $_POST['password'] != ''){
        $login = $db->prepare('SELECT * FROM members WHERE email = ? AND password = ?');
        $login->execute(array(
        $_POST['mail'],
        password_hash($_POST['password'], PASSWORD_DEFAULT)
        ));
        $member = $login->fetch();

        // DBに該当するデータがある場合
        if($member){
            $_SESSION['userid'] = $member['id'];
            $_SESSION['time'] = time();
            header('Location: ./create_view.php');
            exit();

        // 該当データがない場合
        } else {
            $error['login'] = 'failed';
        }
    // 入力漏れがある場合
    } else {
        $error['login'] = 'blank';
    }
}

?>

<!doctype html>
<html lang="ja">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Title</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="./css/post_style.css">
</head>

<body>
    <header class="page-header">
        <div class="header-wrapper">
            <p>TodoList</p>
            <nav>
                <ul class="main-nav">
                    <li><a href="">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="login-form">
        <form action="">
            <div>
                <h2>ログイン</h2>
            </div>
            <dl>
                <dt>
                    <p>メールアドレス</p>
                </dt>
                <dd>
                    <input type="text" name="mail" size="35" maxlength="255">
                </dd>
                <dt>
                    <p>パスワード</p>
                </dt>
                <dd>
                    <input type="password" name="password" size="35" maxlength="100">
                </dd>
                <dt>
                    <p>ログイン情報の記録</p>
                </dt>
                <dd>
                    <input type="checkbox" name="save" id="save" value="on"><label for="save">次回からは自動的にログインする</label>
                </dd>
            </dl>
            <div>
                <input type="submit" value="ログインする">
            </div>
        </form>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</html>