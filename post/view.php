<?php
session_start();
require('./dbconnect.php');

// idがセットされ、タイムアウトしていないかチェック
if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    // 両方満たしている場合
    $_SESSION['time'] = time();

    // DBからTodoの詳細を取得する
    $tasks = $db->prepare('SELECT * FROM todo_list WHERE id =? AND member_id = ?');
    $tasks->execute(array(
        $_GET['no'],
        $_SESSION['id']
    ));

    // $message = 'ifの中には入っているよ';

} else {
    // 満たしていない場合
    header('Location: ./login.php');
    exit();
}
?>

<!doctype html>
<html lang="ja">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>View</title>

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

    <main>
        <?php if($task = $tasks->fetch()): ?>
            <h1><?php echo $task['title']; ?></h1>
            <h3><?php echo htmlspecialchars($task['contents'], ENT_QUOTES); ?></h3>
            <p>作成日 : <?php echo htmlspecialchars($task['created'], ENT_QUOTES); ?></p>
            <?php if($task['created'] != $task['modified']): ?>
                <p>修正日 : <?php echo htmlspecialchars($task['modified'], ENT_QUOTES); ?></p>
            <?php endif; ?>
        <?php else: ?>
            <p>このTodoは削除されたか、URLが間違えています。</p>
        <?php endif; ?>
        <p><a href="./index.php">&laquo;&nbsp;戻る</a> | <a href="./edit.php?no=<?php echo htmlspecialchars($task['id'], ENT_QUOTES); ?>">編集する</a> | <a href="./delete.php?no=<?php echo htmlspecialchars($task['id'], ENT_QUOTES); ?>">削除する</a></p>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</body>
</html>