<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
        font-family: 'Lora', serif;
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

    main.hero-section {
        position: relative;
        background: linear-gradient(to bottom right, #ff6b6b, #ffd93d, #6bc9ff); /* カラフルな背景グラデーション */
        color: white;
        text-align: center;
        padding: 100px 20px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .hero-section .hero-content h1 {
        font-size: 60px;
        font-weight: bold;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    }

    .hero-section .hero-content p {
        font-size: 20px;
        margin-bottom: 30px;
        font-weight: 300;
    }

    .hero-section form {
        display: flex;
        justify-content: center;
        gap: 10px; /* 要素間の間隔を設定 */
        margin-bottom: 30px;
    }

    .hero-section input[type="text"] {
        width: 300px;
        max-width: 100%;
        padding: 15px;
        border-radius: 50px; /* 丸みを帯びたデザイン */
        border: 2px solid rgba(255, 255, 255, 0.8);
        font-size: 18px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transition: all 0.3s ease;
    }

    .hero-section input[type="text"]::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .hero-section input[type="text"]:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.4);
        color: white;
    }

    .hero-section button {
        padding: 15px 30px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .hero-section button:hover {
        background-color: white;
        color: rgba(0, 0, 0, 0.8);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }

    .hero-section .button-group {
        display: flex;
        justify-content: center;
        gap: 20px; /* ボタン間のスペース */
        margin-top: 20px;
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
    
    <main class="hero-section">
    <div class="hero-content">
        <h1>ようこそ、Traveeelへ！</h1>
        <p>新しい旅行プランを作成し、オリジナルのプランを計画しましょう。</p>
        <form action="search_results.php" method="post">
            <input type="text" name="search" placeholder="プランまたはキーワードを入力">
            <button type="submit">検索</button>
        </form>
        <div class="button-group">
            <button onclick="window.location.href='create_plan.php'">新しいプランを作成する</button>
            <button onclick="window.location.href='view_plans.php'">過去の旅行プランを見る</button>
        </div>
    </div>
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
