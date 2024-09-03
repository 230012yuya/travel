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

$user_id = $_SESSION['user_id']; // これを取得するために、ログイン時にユーザーIDもセッションに保存する必要があります
$sql = "SELECT id, destination, start_date, end_date FROM plans WHERE user_id='$user_id'";
$result = $conn->query($sql);

?>

<style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar .icon {
            display: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        @media screen and (max-width: 600px) {
            .navbar a:not(:first-child) {display: none;}
            .navbar a.icon {
                float: right;
                display: block;
            }
        }
        @media screen and (max-width: 600px) {
            .navbar.responsive {position: relative;}
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
    </style>

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
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン表示</title>
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
        <h1>旅行プラン表示</h1>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li>" . $row["destination"] . " (" . $row["start_date"] . " - " . $row["end_date"] . ")</li>";
                }
            } else {
                echo "旅行プランが見つかりませんでした";
            }
            $conn->close();
            ?>
        </ul>
    </main>
</body>
</html>