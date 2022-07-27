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

    $tasks = $db->prepare('SELECT * FROM todo_list WHERE id = ? AND member_id = ?');
    $tasks->execute(array(
        $_GET['id'],
        $_SESSION['id']
    ));

    $task = $tasks->fetch();

    if($task['member_id'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM todo_list WHERE id = ?');
        $del->execute(array($task['id']));
    }
}

header('Location: ./index.php');
exit();

?>
<!doctype html>
<html lang="ja">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>delete</title>

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
        <h1>hello world</h1>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</body>
</html>