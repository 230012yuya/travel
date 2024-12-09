<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff; /* 柔らかいパステルブルー */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9); /* 少し濃い目の背景 */
            padding: 0 15px;
            font-size: 18px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9; /* 柔らかいピンク */
            color: #fff;
            transform: scale(1.05); /* ホバー時の動き */
        }

        /* Traveeelタイトル */
        .title {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 50px;
            font-weight: bold;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d, #6bc9ff);
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .title:hover {
            transform: scale(1.1) rotate(5deg);
        }

        main {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* 柔らかい白背景 */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            font-size: 32px;
            color: #3a506b; /* 落ち着いた青 */
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            gap: 10px; /* 要素間の間隔を設定 */
        }

        input[type="text"] {
            width: calc(100% - 140px);
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #ffb6b9; /* カラフルさをプラス */
            margin-right: 10px;
            font-size: 18px;
            color: #333;
        }

        button {
            padding: 15px 30px;
            background-color: #ff6b6b; /* カラフルな赤 */
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: #ffd93d; /* 明るい黄色に変更 */
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:active {
            background-color: #ff6b6b;
            transform: scale(1.02);
        }

        /* 不要なボタンを削除 */
        .navbar .icon {
            display: none;
        }

        @media screen and (max-width: 768px) {
            input[type="text"] {
                width: calc(100% - 160px);
            }
        }

    </style>
</head>
<body>
    <div class="navbar" id="myNavbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="display.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <a href="javascript:void(0);" onclick="confirmLogout()">ログアウト</a>
    </div>
    
    <main>
        <h1>ホーム</h1>
        <form action="search_results.php" method="post">
            <input type="text" name="search" placeholder="プランを検索" style="margin-right: 10px;">
            <button type="submit">検索</button>
        </form>
        <button onclick="window.location.href='create_plan.php'">新しいプランを作成する</button>
    <button onclick="window.location.href='view_plans.php'">過去の旅行プランを見る</button>
</main>


    <script>
        // ログアウト確認ダイアログ
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php"; // OKが押された場合はログアウト
            }
        }
    </script>
</body>
</html>
