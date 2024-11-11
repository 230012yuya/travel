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

// ユーザーのお気に入りプランを取得
$favorites_sql = "SELECT plan_id FROM user_favorites WHERE user_id='$user_id'";
$favorites_result = $conn->query($favorites_sql);
$favorites = [];
while ($fav_row = $favorites_result->fetch_assoc()) {
    $favorites[] = $fav_row['plan_id'];
}

// 全てのプランを取得
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
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9;
            color: #fff;
            transform: scale(1.05);
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

        main {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        h1 {
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
            transition: transform 0.3s ease;
        }

        li:hover {
            transform: scale(1.02);
        }

        a {
            text-decoration: none;
            color: #ff6b6b;
        }

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

    <div class="title">Traveeel</div>

    <main>
        <h1>旅行プラン一覧</h1>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $is_favorite = in_array($row['id'], $favorites);
                    echo "<li>作成日: " . $row['created_at'] . "<br>目的地: " . $row['destination'] . "<br>旅行日程: " . $row['start_date'] . " ~ " . $row['end_date'] . "<br>";
                    echo "<a href='plan_detail.php?plan_id=" . $row['id'] . "'>詳細を見る</a>";
                    echo "<form action='add_favorite.php' method='post' style='display:inline-block;' onsubmit='return toggleFavorite(event, " . $row['id'] . ");'>";
                    echo "<input type='hidden' name='plan_id' value='" . $row['id'] . "'>";
                    $button_text = $is_favorite ? "登録済み" : "追加";
                    echo "<button class='favorite-btn' id='favorite-btn-" . $row['id'] . "'>$button_text</button>";
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

        function toggleFavorite(event, planId) {
            event.preventDefault();
            const button = document.getElementById(`favorite-btn-${planId}`);
            const action = button.innerText === "追加" ? "add" : "remove";
            button.innerText = action === "add" ? "登録済み" : "追加";

            fetch('add_favorite.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `plan_id=${planId}&action=${action}`
            }).then(response => response.text()).then(data => {
                console.log(data);
            }).catch(error => console.error('エラー:', error));

            return false;
        }
    </script>
</body>
</html>
