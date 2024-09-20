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
            background-image: url('your-image.jpg'); /* 画像を指定 */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* スクロール時に背景を固定 */
            color: #333;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(51, 51, 51, 0.9); /* 半透明の背景色 */
            padding: 0 15px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar a:hover {
            background-color: #575757;
            color: #fff;
        }

        .navbar .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .navbar a:not(:first-child) {
                display: none;
            }
            .navbar a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .navbar.responsive {
                position: relative;
            }
            .navbar.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .navbar.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        main {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* 半透明の背景 */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="text"] {
            width: calc(100% - 120px);
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #5a67d8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #434190;
        }

        button:active {
            background-color: #3730a3;
        }

        .navbar button {
            background-color: transparent;
            border: none;
            color: white;
        }

        @media screen and (max-width: 768px) {
            input[type="text"] {
                width: calc(100% - 140px);
            }
        }
    </style>
</head>
<body>
    <div class="navbar" id="myNavbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="view_plans.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <a href="logout.php">ログアウト</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            &#9776;
        </a>
    </div>
    
    <main>
        <h1>ホーム</h1>
        <form action="search_results.php" method="post">
            <input type="text" name="search" placeholder="プランを検索">
            <button type="submit">検索</button>
        </form>
        <button onclick="window.location.href='create_plan.php'">新しいプランを作成する</button>
        <button onclick="window.location.href='view_plans.php'">過去の旅行プランを見る</button>
    </main>

    <script>
        function myFunction() {
            var x = document.getElementById("myNavbar");
            if (x.className === "navbar") {
                x.className += " responsive";
            } else {
                x.className = "navbar";
            }
        }
    </script>
</body>
</html>
