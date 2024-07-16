<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>登録</h2>
        <form action="register_process.php" method="post">
            <label for="username">ユーザー名:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>
