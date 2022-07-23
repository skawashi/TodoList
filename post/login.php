<?php
session_start();
require('./dbconnect.php');

if(isset($_SESSION['user_id'])) {
    header('Location: ./create_view.php');
    exit();
}

// 入力内容のチェック
if(!empty($_POST)) {
    // 入力漏れがない場合
    if($_POST['mail'] != '' && $_POST['password'] != '') {
        $login = $db->prepare('SELECT * FROM members WHERE email = ?');
        $login->execute(array($_POST['mail']));
        $member = $login->fetch();

        // DBに該当するデータがある場合
        if(password_verify($_POST['password'], $member['password'])) {
            $_SESSION['time'] = time();

            // ログイン情報を保存する場合
            if($_POST['save'] == 'on') {
                $_SESSION['user_id'] = $member['id'];
            }

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
                    <input type="text" name="mail" size="35" maxlength="255" <?php echo htmlspecialchars($_POST['mail'], ENT_QUOTES); ?>>
                </dd>
                <dt>
                    <p>パスワード</p>
                </dt>
                <dd>
                    <input type="password" name="password" size="35" maxlength="100" <?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>>
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