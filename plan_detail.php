<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

if (isset($_GET['plan_id'])) {
    $plan_id = $_GET['plan_id'];

    // プランの詳細を取得
    $sql = "SELECT * FROM plans WHERE id='$plan_id'";
    $result = $conn->query($sql);
    $plan = $result->fetch_assoc();
} else {
    // プランIDが指定されていない場合の処理
    echo "プランが指定されていません。";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>プラン詳細</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
         body {
            font-family: 'Roboto', sans-serif;
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
            background-color: rgba(255, 255, 255, 0.9); /* 半透明の背景 */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #ff6b6b; /* カラフルな赤 */
            font-size: 28px; /* タイトルサイズ */
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none; /* リストのスタイルをなしに */
            padding: 0;
        }

        li {
            background-color: #e3f2fd; /* 各プランの背景色 */
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            transition: transform 0.2s;
        }

        li:hover {
            transform: scale(1.02); /* ホバー時に少し拡大 */
        }
        .plan-detail {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        <!-- ログアウトボタン -->
        <a href="javascript:void(0);" onclick="confirmLogout()">ログアウト</a>
    </div>

    <!-- Traveeelのタイトル -->
    <div class="title">Traveeel</div>
    <div class="plan-detail">
    <h1>プラン詳細</h1>
    <p>出発地点: <?php echo $plan['departure_point']; ?></p>
    <p>目的地: <?php echo $plan['destination']; ?></p>
    <p>出発日: <?php echo $plan['start_date']; ?></p>
    <p>帰着日: <?php echo $plan['end_date']; ?></p>
    <p>人数: <?php echo $plan['number_of_people']; ?>人</p>
    <p>予算: <?php echo $plan['budget']; ?>円</p>
    <p>詳細: <?php echo $plan['details']; ?></p>
    <!-- 編集ボタンの追加 -->
    <a href="edit_plan.php?plan_id=<?php echo $plan['id']; ?>">編集する</a>
    <a href="view_plans.php">戻る</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>