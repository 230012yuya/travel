<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
    <style>
        /* Google Fontsのインポート */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Roboto:wght@400;500&display=swap');

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-image: url(images/landscape_00028.jpg);
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
            color: #f39c12;
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
        input[type="password"],
        input[type="file"] {
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
        input[type="password"]:focus,
        input[type="file"]:focus {
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
    <h1 class="title">Traveeel</h1>
    <div class="container">
        <h2>ユーザー登録</h2>
        <form action="register_process.php" method="post" enctype="multipart/form-data">
            <label for="name">ユーザー名:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Eメール:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>

            <label for="profile_image">プロフィール画像を選択:</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">

            <button type="submit">登録する</button>
        </form>
        <p>すでにアカウントをお持ちでしたら<a href="login.php">こちら</a>からログイン</p>
    </div>
</body>
</html>
