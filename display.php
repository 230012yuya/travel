<?php
// display.php でプランデータを表示
if (isset($_GET['plan'])) {
    $plan = htmlspecialchars($_GET['plan']);
} else {
    $plan = "旅行プランが生成されませんでした。";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>生成された旅行プラン</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9);
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
            background-color: #ffb6b9;
            color: #fff;
            transform: scale(1.05);
        }
        .form-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .plan-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #ff6b6b;
        }
        .plan {
            white-space: pre-wrap;
            word-wrap: break-word;
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
    <div class="plan-container">
        <h1>生成された旅行プラン</h1>
        <div class="plan">
            <?= $plan ?>
        </div>
    </div>
</body>
</html>
