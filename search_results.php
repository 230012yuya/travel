<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$search_query = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';

$sql = "SELECT * FROM plans WHERE 
        departure_point LIKE '%$search_query%' OR 
        destination LIKE '%$search_query%' OR 
        number_of_people LIKE '%$search_query%' OR 
        budget LIKE '%$search_query%'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
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
        .main-content {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #ff6b6b;
            font-size: 28px;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #e3f2fd;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        a {
            text-decoration: none;
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="display.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <a href="javascript:void(0);" onclick="confirmLogout()">ログアウト</a>
    </div>

    <div class="main-content">
        <h1>検索結果</h1>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<strong>出発地:</strong> " . htmlspecialchars($row['departure_point']) . "<br>";
                    echo "<strong>目的地:</strong> " . htmlspecialchars($row['destination']) . "<br>";
                    echo "<strong>日程:</strong> " . htmlspecialchars($row['start_date']) . " ~ " . htmlspecialchars($row['end_date']) . "<br>";
                    echo "<strong>人数:</strong> " . htmlspecialchars($row['number_of_people']) . "人<br>";
                    echo "<strong>予算:</strong> ¥" . number_format($row['budget'], 2) . "<br>";
                    echo "<a href='plan_detail.php?plan_id=" . $row['id'] . "'>詳細を見る</a>";
                    echo "</li>";
                }
            } else {
                echo "<p>検索に一致するプランはありません。</p>";
            }
            $conn->close();
            ?>
        </ul>
    </div>

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
