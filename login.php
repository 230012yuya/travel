<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <style>
        /* Google Fontsのインポート */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Roboto:wght@400;500&display=swap');

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url(images/1703145_s.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
        }

        .title {
            text-align: center;
            margin-top: 40px;
            font-size: 48px;
            font-weight: 600;
            color: #f39c12;
            font-family: 'Poppins', sans-serif;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(240, 240, 240, 0.8));
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #34495E;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 24px;
            font-family: 'Roboto', sans-serif;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 14px;
            color: #555;
            font-family: 'Roboto', sans-serif;
        }

        input[type="text"],
        input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 12px;
            background: linear-gradient(135deg, #3498DB, #2ECC71);
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        a.google-login {
            display: inline-block;
            padding: 12px 20px;
            background: linear-gradient(135deg, #DB4437, #FF7043);
            color: white;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        a.google-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
        }

        p a {
            color: #2980B9;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1 class="title">Traveeel</h1>
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
        <div style="text-align: center; margin-top: 20px;">
            <a href="google_login.php" class="google-login">Googleでログイン</a>
        </div>
    </div>
</body>
</html>
