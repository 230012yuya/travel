<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel_plan_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$search_keyword = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_keyword = $_POST['search'];
}

$sql = "SELECT id, destination, start_date, end_date FROM plans WHERE user_id='$user_id' AND (destination LIKE '%$search_keyword%' OR details LIKE '%$search_keyword%')";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">ホーム</a></li>
                <li><a href="create_plan.php">旅行プラン作成</a></li>
                <li><a href="view_plans.php">旅行プラン表示</a></li>
                <li><a href="profile.php">プロフィール</a></li>
                <li><a href="past_plans.php">過去の旅行プラン</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>検索結果</h1>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li>" . $row["destination"] . " (" . $row["start_date"] . " - " . $row["end_date"] . ")</li>";
                }
            } else {
                echo "プランが見つかりませんでした";
            }
            $conn->close();
            ?>
        </ul>
    </main>
</body>
</html>
