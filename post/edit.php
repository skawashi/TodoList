<?php
session_start();
require('./dbconnect.php');
require('./function.php');

// XSS対策
header('Content-Type: text/html; charset = UTF-8');

if(islogin()) {
    // ログイン中の場合の処理

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
        // $task = $tasks->fetch();

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
<link rel="stylesheet" href="./css/global.css">
<link rel="stylesheet" href="./css/header_footer.css">
<link rel="stylesheet" href="./css/post_edit.css">
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

    <main class="todo-edit">
        <div class="edit-form">
            <?php if($task = $tasks->fetch()): ?>
                <form action="" method="post">
                    <dl>
                        <dt>
                            <p class="title-label">Todo</p>
                        </dt>
                        <dd>
                        <input type="text" name="title" class="title" value="<?php echo hsc($task['title']); ?>">
                        </dd>
                        <dt>
                            <p class="contents-label">内容</p>
                        </dt>
                        <dd>
                            <textarea name="contents" class="contents" cols="30" rows="10"><?php echo hsc($task['contents']); ?></textarea>
                        </dd>
                    </dl>
                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                    <div class="option">
                        <p><a class="return" href="./index.php">&laquo;&nbsp;戻る</a>
                        <input type="submit" class="button" value="変更する">
                    </div>
                </form>
            <?php else: ?>
                <p class="deleted">このTodoは削除されたか、URLが間違えています。</p>
                <p><a href="./index.php">&laquo;&nbsp;戻る</a>
            <?php endif; ?>
        </div>

    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</body>
</html>