<?php
session_start();
require('./dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + $_SESSION['timeout'] > time()) {
    // 両方満たしている場合
    $_SESSION['time'] = time();

    if(empty($_GET['id'])) {
        // クエリストリングにidが指定されていない場合
        header('Location: ./index.php');
        exit();
    }

    if(empty($_POST)) {
        // 「編集する」からこのページに飛んできた時
        $tasks = $db->prepare('SELECT * FROM todo_list WHERE id = ? AND member_id = ?');
        $tasks->execute(array(
            $_GET['id'],
            $_SESSION['id']
        ));
        $task = $tasks->fetch();
        // $message = 'ifの中にははいっているよ';
    } else {
        // 編集を行なった時
        $tasks = $db->prepare('UPDATE todo_list SET title = ?, contents = ?, modified = NOW() WHERE id = ?');
        $tasks->execute(array(
            $_POST['title'],
            $_POST['contents'],
            $_POST ['id']
        ));
        header("Location: ./view.php?id={$_POST['id']}");
        exit();
    }

} else {
    // 満たしていない場合
    header('Location: ./index.php');
    exit();
}


?>

<!doctype html>
<html lang="ja">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>edit</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="./css/post_style.css">
</head>

<body>
    <header class="page-header">
        <div class="header-wrapper">
            <p>TodoList</p>
            <nav>
                <ul class="main-nav">
                    <li><a href="./logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div>
            <h1><?php echo $message; ?></h1>
            <form action="" method="post">
                <dl>
                    <dt>
                        <p>todo</p>
                    </dt>
                    <dd>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($task['title'], ENT_QUOTES); ?>">
                    </dd>
                    <dt>
                        <p>内容</p>
                    </dt>
                    <dd>
                        <textarea name="contents" cols="30" rows="10"><?php echo htmlspecialchars($task['contents'], ENT_QUOTES); ?></textarea>
                    </dd>
                </dl>
                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                <input type="submit" value="変更する">
            </form>
        </div>
        <p><a href="./index.php">&laquo;&nbsp;戻る</a>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</body>
</html>