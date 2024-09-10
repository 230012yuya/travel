<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>ログイン</h2>
        <form action="authenticate.php" method="post">
            <label for="name">ユーザー名:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">ログイン</button>
        </form>
        <p>アカウントをお持ちでない方は <a href="register.php">こちら</a> から登録してください。</p>
        <!-- Googleログインボタン -->
        <div>
            <a href="google_login.php">Googleでログイン</a>
        </div>

    </div>
</body>
</html>
