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
                    <li>ログイン</li>
                    <li>会員登録</li>
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
                <dd><input type="text" name="name" class="input-size"></dd>
                <dt>メールアドレス</dt>
                <dd><input type="text" name="mail" class="input-size"></dd>
                <dt>パスワード</dt>
                <dd><input type="password" name="password" class="input-size"></dd>
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