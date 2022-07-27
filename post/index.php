<?php
session_start();
require('./dbconnect.php');

// XSS対策
header('Content-Type: text/html; charset = UTF-8');
function hsc($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// idセットされ、タイムアウトしていないかチェック
if(isset($_SESSION['id']) && $_SESSION['time'] + $_SESSION['timeout'] > time()) {
    // 両方満たしている場合
    $_SESSION['time'] = time();

    // 会員情報の取得
    $members = $db->prepare('SELECT * FROM members Where id = ?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();


} else {
    // 満たしていない場合
    header('Location: ./login.php');
    exit();
}

// Todoを記録
if(!empty($_POST)) {
    if($_POST['title'] != '') {
        $post = $db->prepare('INSERT INTO todo_list SET title = ?, contents = ?, member_id = ?, created = NOW()');
        $post->execute(array(
            $_POST['title'],
            $_POST['contents'],
            $member['id']
        ));
        // リロード時、同じ内容が記録されるのを防止するためのリダイレクト
        header('Location: ./index.php');
    }
}

// Todoを取得
$tasks = $db->prepare('SELECT * FROM todo_list WHERE member_id = ? ORDER BY created ASC' );
$tasks->execute(array($member['id']));
?>

<!doctype html>
<html lang="ja">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>入力および表示</title>

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
                        <textarea name="contents" cols="50" rows="5" placeholder="Todoの詳細"></textarea>
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
                <!-- 取得したtodoの配列から1つずつ取り出す -->
                <?php
                foreach($tasks as $task):
                ?>
                    <li><a href="./view.php?id=<?php echo hsc($task['id']); ?>"><?php echo hsc($task['title']); ?></a><span> <a href="./edit.php?id=<?php echo hsc($task['id']); ?>">編集</a> </span><span> <a href="./delete.php?id=<?php echo hsc($task['id']); ?>">削除</a> </span></li>
                <?php
                endforeach;
                ?>
            </ul>

        </div>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</html>