<?php
session_start();
require('./dbconnect.php');

// ログイン認証されている場合
if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $members = $db->prepare('SELECT * FROM members Where id = ?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();

// ログイン認証されていない場合
} else {
    header('Location: ./login.php');
    exit();
}

if(!empty($_POST)) {
    if($_POST['title'] != '') {
        $todo = $db->prepare('INSERT INTO todo-list SET title = ?, contents = contents, member_id = ?, created = NOW()');
        $todo->execute(array(
            $_POST['title'],
            $_POST['contents'],
            $_SESSION['id']
        ));

        header('Location: ./index.php');
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

    <main class="container">
        <div class="todo-input">
            <div class="title">
                <p>Todoインプット</p>
            </div>
            <form action="" method="post">
                <dl>
                    <dt>
                        <input type="text" name="title" placeholder="Todo">
                    </dt>
                    <dt>
                        <input type="text" name="contents" placeholder="内容">
                    </dt>
                </dl>
                <input type="submit">
            </form>
        </div>
        <div class="todo-table">
            <div class="title">
                <p><?php echo $member['name'] . 'さんのTodoリスト'?></p>
            </div>
            <ul>
                <li>task1</li>
                <li>task2</li>
            </ul>

        </div>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</html>