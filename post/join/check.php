<?php
session_start();
require('../dbconnect.php');

if(!isset($_SESSION['join'])) {
    header('Location: ./index.php');
    exit();
}

if(!empty($_POST)) {
    $statement = $db->prepare('INSERT INTO members SET name = ?, email = ?, password = ?, created = NOW()');
    $statement->execute(array(
        $_SESSION['join']['name'],
        $_SESSION['join']['mail'],
        password_hash($_SESSION['join']['password'], PASSWORD_DEFAULT)
    ));
    unset($_SESSION['join']);

    header('Location: ./thanks.php');
    exit();
}

// if(!empty($_POST)) {
//     $statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, created=NOW()');
// }
?>

<!doctype html>
<html lang="ja">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Title</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="style.css">
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

    <main>
        <form action="" method="POST">
            <input type="hidden" name="action" value="submit">
            <div>
                <p>以下の内容で登録します</p>
            </div>
            <dl>
                <dt>ユーザーネーム</dt>
                <dd><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></dd>
                <dt>メールアドレス</dt>
                <dd><?php echo htmlspecialchars($_SESSION['join']['mail'], ENT_QUOTES); ?></dd>
                <dt>パスワード</dt>
                <dd>【表示されません】</dd>
            </dl>
            <div>
                <a href="./index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する">
            </div>
        </form>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>

</body>
</html>