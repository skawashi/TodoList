<?php
session_start();
require('../dbconnect.php');

// フォームのエラーチェック
if(!empty($_POST)) {
    if($_POST['name'] == '') {
        $error['name'] = 'blank';
    }

    if($_POST['mail'] == '') {
        $error['mail'] = 'blank';
    }

    if($_POST['password'] == '') {
        $error['password'] = 'blank';
    } elseif(strlen($_POST['password']) < 4) {
        $error['password'] = 'length';
    }

    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email = ?');
    $member->execute(array($_POST['mail']));
    $record = $member->fetch();
    if($record['cnt'] > 0) {
        $error['mail'] = 'duplicate';
    }

    if(empty($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: ./check.php');
        exit();
    }
}

if($_GET['action'] == 'rewrite') {
    $_POST = $_SESSION['join'];
    // 現在は必要ないが、画像を登録してもらう際はもう一度指定してもらう必要があるのでそのフラグ用
    $error['rewrite'] = 'true';
}
?>

<?php
    function hsc($value) {
        return htmlspecialchars($value, ENT_QUOTES);
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
<link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header class="page-header">
        <div class="header-wrapper">
            <p>TodoList</p>
            <nav>
                <ul class="main-nav">
                    <li><a href="../index.php">ログイン</a></li>
                    <li><a href="./index.php">会員登録</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="login-form">
        <form action="" method="POST" class="form">
            <div class="title">
                <h2>会員登録</h2>
            </div>
            <dl>
                <dt>ユーザーネーム</dt>
                <dd>
                    <input type="text" name="name" size="35" maxlength="255" value="<?php echo hsc($_POST['name']); ?>" class="input-size">
                    <?php if($error['name'] == 'blank'): ?>
                        <p class="error">* ユーザーネームを入力してください</p>
                    <?php endif; ?>
                </dd>
                <dt>メールアドレス</dt>
                <dd>
                    <input type="text" name="mail" size="35" maxlength="255" value="<?php echo hsc($_POST['mail']) ?>" class="input-size">
                    <?php if($error['mail'] == 'blank'): ?>
                        <p class="error">* メールアドレスを入力してください</p>
                    <?php endif; ?>
                    <?php if($error['mail'] == 'duplicate'): ?>
                        <p>* このメールアドレスは既に登録されています</p>
                    <?php endif; ?>
                </dd>
                <dt>パスワード</dt>
                <dd>
                    <input type="password" name="password" size="10" maxlength="100" value="<?php echo hsc($_POST['password']); ?>" class="input-size">
                    <?php if($error['password'] == 'blank'): ?>
                        <p class="error">* パスワードを入力してください</p>
                    <?php endif; ?>
                    <?php if($error['password'] == 'length'): ?>
                        <p class="error">* パスワードは4文字以上で設定してください</p>
                    <?php endif; ?>
                </dd>
            </dl>
            <div class="submit">
                <input type="submit" value="登録する" class="button">
            </div>
        </form>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>

</body>
</html>