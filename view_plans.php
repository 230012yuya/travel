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

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, destination, start_date, end_date FROM plans WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン表示</title>
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
            max-height: 400px; /* 最大の高さを設定（必要に応じて調整） */
            overflow-y: auto; /* 縦方向のスクロールを有効に */
            border: 1px solid #ddd; /* 境界線を追加 */
            border-radius: 5px; /* 角を丸める */
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

    <main>
        <h1>旅行プラン表示</h1>
        <ul>
            <?php
            $sql = "SELECT id, created_at, destination, start_date, end_date FROM plans WHERE user_id='$user_id'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // プラン情報を表示するループ
                while ($row = $result->fetch_assoc()) {
                    echo "<li>作成日　　:" . $row['created_at'] . " <br>目的地　　: " . $row['destination'] . " <br>旅行日程　: " . $row['start_date'] . " ~ " . $row['end_date'] . "</li>";
                    
                    // ここに詳細リンクを追加
                    echo "<a href='plan_detail.php?plan_id=" . $row['id'] . "'>詳細を見る</a>";
                    
                }
            } else {
                echo "作成したプランはありません。";
            }
            $conn->close();
            ?>
        </ul>
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
