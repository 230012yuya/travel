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

// お気に入りの数を制限するためのクエリ
$favorites_sql = "SELECT COUNT(*) AS favorite_count FROM user_favorites WHERE user_id='$user_id'";
$favorites_result = $conn->query($favorites_sql);
$favorites_count = $favorites_result->fetch_assoc()['favorite_count'];

// お気に入りを追加する処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($favorites_count < 3) {
        $plan_id = $_POST['plan_id'];
        $insert_sql = "INSERT INTO user_favorites (user_id, plan_id) VALUES ('$user_id', '$plan_id')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('お気に入りに追加しました。');</script>";
        } else {
            echo "エラー: " . $conn->error;
        }
    } else {
        echo "<script>alert('お気に入りは最大3つまで選択できます。');</script>";
    }
}

// ユーザーのプランを取得
$sql = "SELECT id, destination, start_date, end_date, created_at FROM plans WHERE user_id='$user_id'";
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
        }

        main {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #ff6b6b;
            font-size: 28px;
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        li {
            background-color: #e3f2fd;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            position: relative;
        }

        li:hover {
            transform: scale(1.02);
        }

        a {
            text-decoration: none;
            color: #ff6b6b;
        }

         /* 自然な感じのボタンスタイル */
         .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 15px;
            background-color: #ffd1dc;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, transform 0.3s;
        }

        .favorite-btn:hover {
            background-color: #ff6b6b;
            transform: scale(1.05);
        }

        .favorite-btn:active {
            background-color: #ff4d4d;
            transform: scale(0.95);
        }

        .favorite-btn i {
            margin-right: 5px;
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
        <h1>過去の旅行プラン</h1>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>作成日　　: " . $row['created_at'] . "<br>目的地　　: " . $row['destination'] . "<br>旅行日程　: " . $row['start_date'] . " ~ " . $row['end_date'] . "<br>";
                    
                    // プラン詳細リンク
                    echo "<a href='plan_detail.php?plan_id=" . $row['id'] . "'>詳細を見る</a>";

                     // お気に入りボタンをハートアイコンに変更
                     echo "<form action='add_favorite.php' method='post' style='display:inline-block;'>";
                     echo "<input type='hidden' name='plan_id' value='" . $row['id'] . "'>";
                     echo "<button class='favorite-btn'><i>❤️</i>追加</button>";
                     echo "</form>";
                     
                     echo "</li>";
                 }
            } else {
                echo "<p>作成したプランはありません。</p>";
            }
            $conn->close();
            ?>
        </ul>
    </main>

    <script>
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body> 
</html>
