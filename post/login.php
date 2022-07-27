<?php
session_start();
require('./dbconnect.php');
require('./function.php');

// XSS対策
header('Content-Type: text/html; charset = UTF-8');

// ToDo 徳丸本(p482)を参考に認証処理を行う
// 入力内容のチェック
if(!empty($_POST)) {
    // 入力漏れがない場合
    if($_POST['mail'] != '' && $_POST['password'] != '') {
        $login = $db->prepare('SELECT * FROM members WHERE email = ?');
        $login->execute(array($_POST['mail']));
        $member = $login->fetch();

        // DBから取り出したパスワードと入力されたパスワードの照合
        if(password_verify($_POST['password'], $member['password'])) {
            // パスワードが一致した場合
            $autologin = ($_POST['autologin'] === 'on');
            $timeout = 30 * 60;

            if($autologin) {
                // 自動ログインする場合
                $timeout = 7 * 24 * 60 * 60;
                session_set_cookie_params($timeout);
                $_SESSION['message'] = '自動ログイン中';
            }

            // セッションIDの再生成
            session_regenerate_id(true);
            $_SESSION['id'] = $member['id'];
            $_SESSION['timeout'] = $timeout; // タイムアウト時間
            $_SESSION['expires'] = time() + $timeout; // タイムアウト時刻

            header('Location: ./index.php');
            exit();

        } else {
            // パスワードが一致しなかった場合
            $error['login'] = 'failed';
        }
    // フォームに入力漏れがある場合
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
<title>ログイン</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="./css/post_style.css">
</head>

<body>
    <header class="page-header">
        <div class="header-wrapper">
            <p>TodoList</p>
            <nav>
                <ul class="main-nav">
                    <li><a href="./join/index.php">会員登録</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="login-form">
        <div>
            <h2>ログイン</h2>
        </div>
        <?php if($error['login'] == 'blank'): ?>
            <div>
                <p>メールアドレスとパスワードをご記入ください</p>
            </div>
        <?php endif; ?>
        <?php if($error['login'] == 'failed'): ?>
            <div>
                <p>ログインに失敗しました。正しく入力してください。</p>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <dl>
                <dt>
                    <p>メールアドレス</p>
                </dt>
                <dd>
                    <input type="text" name="mail" size="35" maxlength="255" <?php echo hsc($_POST['mail']); ?>>
                </dd>
                <dt>
                    <p>パスワード</p>
                </dt>
                <dd>
                    <input type="password" name="password" size="35" maxlength="100" <?php echo hsc($_POST['password']); ?>>
                </dd>
                <dt>
                    <p>ログイン情報の記録</p>
                </dt>
                <dd>
                    <input type="checkbox" name="autologin" id="autologin" value="on"><label for="autologin">次回からは自動的にログインする</label>
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
</body>
</html>