<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <style>
        /* Google Fontsのインポート */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Roboto:wght@400;500&family=Montserrat:wght@400;700&display=swap');

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url(images//photo-1503221043305-f7498f8b7888.avif);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .title {
            text-align: center;
            font-size: 50px;
            font-weight: 700;
            color: #f39c12;
            font-family: 'Montserrat', sans-serif;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .container {
            max-width: 400px;
            width: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(240, 240, 240, 0.8));
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #34495E;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 26px;
            font-family: 'Montserrat', sans-serif;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 15px;
            color: #555;
            font-family: 'Roboto', sans-serif;
            text-align: left;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
        }

        button {
            padding: 12px;
            background: linear-gradient(135deg, #3498DB, #2ECC71);
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            width: 100%;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .google-login {
            display: block;
            padding: 12px;
            background: linear-gradient(135deg, #DB4437, #FF7043);
            color: white;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            margin-top: 20px;
            text-align: center;
        }

        .google-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        p {
            font-size: 15px;
            font-family: 'Roboto', sans-serif;
            margin-top: 15px;
        }

        p a {
            color: #2980B9;
            text-decoration: none;
            font-weight: 500;
            font-family: 'Montserrat', sans-serif;
        }

        p a:hover {
            text-decoration: underline;
        }
        @keyframes wave {
    0% {
        transform: rotate(0deg);
    }
    25% {
        transform: rotate(5deg);
    }
    50% {
        transform: rotate(0deg);
    }
    75% {
        transform: rotate(-5deg);
    }
    100% {
        transform: rotate(0deg);
    }
}

.title {
    animation: wave 1s ease-in-out infinite;
    text-align: center;
    font-size: 50px;
    font-weight: 700;
    color: #f39c12;
    font-family: 'Montserrat', sans-serif;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Traveeel</h1>
        <h2>ログイン</h2>
        <form action="authenticate.php" method="post">
            <div>
                <label for="name">ユーザー名:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="password">パスワード:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">ログイン</button>
        </form>

        <p>アカウントをお持ちでない方は <a href="register.php">こちら</a> から登録してください。</p>
    </div>
</body>
</html>
