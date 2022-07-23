<?php
session_start();
require('./dbconnect.php');
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
                        <input type="text" name="content" placeholder="内容">
                    </dt>
                </dl>
                <input type="submit">
            </form>
        </div>
        <div class="todo-table">
            <div class="title">
                <p>一覧表示</p>
            </div>

        </div>
    </main>

    <footer class="page-footer footer-wrapper">
        <p><small>&copy; 2022 TODO_LIST</small></p>
    </footer>
</html>