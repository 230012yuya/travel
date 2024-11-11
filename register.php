<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
    <style>
        /* Google Fontsのインポート */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Poppins:wght@300;600&family=Roboto:wght@400;500&display=swap');

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url(images/photo-1668640019831-072823bc0ce1.avif);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(240, 240, 240, 0.8));
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            font-size: 50px;
            font-weight: 700;
            color: #f39c12;
            font-family: 'Montserrat', sans-serif;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            animation: move 2s ease-in-out infinite;
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

h1 {
    animation: wave 1s ease-in-out infinite;
    text-align: center;
    font-size: 50px;
    font-weight: 700;
    color: #f39c12;
    font-family: 'Montserrat', sans-serif;
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    margin-bottom: 20px;
}

        

        h2 {
            text-align: center;
            color: black;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 26px;
            font-family: 'Poppins', sans-serif;
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
        input[type="email"],
        input[type="password"] {
            padding: 12px;
            border: 2px solid #f39c12;
            border-radius: 20px;
            outline: none;
            background-color: #fffae6;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            background-color: #fffacd;
            border-color: #f1c40f;
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
    <div class="container">
        <h1>Traveeel</h1>
        <h2>ユーザー登録</h2>
        <form action="register_process.php" method="post" enctype="multipart/form-data">
    <label for="name">ユーザー名:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Eメール:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">パスワード:</label>
    <input type="password" id="password" name="password" required>

    <label for="profile_image">プロフィール画像:</label>
    <input type="file" id="profile_image" name="profile_image" accept="image/*">

    <button type="submit">登録する</button>
</form>

        <p>すでにアカウントをお持ちでしたら<a href="login.php">こちら</a>からログイン</p>
    </div>
</body>
</html>
