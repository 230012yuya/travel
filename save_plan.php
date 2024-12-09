<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// データベース接続設定
$host = 'localhost';
$db_username = "root";
$db_password = "";
$dbname = "travel";

$plan = $_SESSION['ai_plan']['plan'];
$plan['user_id'] = $_SESSION['user_id'];
$plan_schedule = $_SESSION['ai_plan']['plan_schedule'];

$info = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    // PDOを使用してデータベースに接続
    $pdo = new PDO($info, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // トランザクションを開始
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO plans (user_id, departure_point, destination, start_date, end_date, details, budget, number_of_people)
        VALUES (:user_id, :departure_point, :destination, :start_date, :end_date, :details, :budget, :number_of_people)");
    $stmt->execute($plan);

    // 新しく作成されたplanのIDを取得
    $planId = $pdo->lastInsertId();

    // plan_itemsテーブルにデータをINSERT
    $stmt = $pdo->prepare("
        INSERT INTO plan_schedule (plan_id, day, time, activity)
        VALUES (:plan_id, :day, :time, :activity)
    ");

    foreach ($plan_schedule as $item) {
        $item['plan_id'] = $planId;
        $stmt->execute($item);
    }

    // トランザクションをコミット
    $pdo->commit();

 ?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン作成</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* CSS スタイル */
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

        h1 {
            text-align: center;
            color: #ff6b6b;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ff3b3b;
        }

        .error-message {
            color: red;
            text-align: center;
            font-size: 16px;
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

<?php
   // 成功メッセージを表示
   echo "<h1>プランの保存に成功しました！</h1>";
   echo "<a href='display.php'>プランを見る</a>";
} catch (PDOException $e) {
   // エラーが発生した場合はロールバック
   $pdo->rollBack();
   http_response_code(500); // 内部サーバーエラー
   echo "<h1>プランの保存に失敗しました。</h1>";
   echo "<p>エラー: " . htmlspecialchars($e->getMessage()) . "</p>";
   echo "<a href='create_plan.php'>もう一度試す</a>";
}
?>