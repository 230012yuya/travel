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

// カスタマイズ可能なプランを取得
$sql_plans = "SELECT id, destination, start_date, end_date FROM plans WHERE user_id = '$user_id'";
$plans_result = $conn->query($sql_plans);

// 招待送信処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invite_email'])) {
    $invite_email = $_POST['invite_email'];
    // 招待処理をここに追加
    // 例: メール送信
    echo "<script>alert('招待状を $invite_email に送信しました！');</script>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プラン共有</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f9ff; /* 柔らかいパステルブルー */
            margin: 0;
            padding: 0;
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
            transition: background-color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9; /* 柔らかいピンク */
        }

        h1 {
            text-align: center;
            color: #ff6b6b; /* カラフルな赤 */
            margin-top: 20px;
        }

        main {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* 半透明の背景 */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            background-color: #ff6b6b; /* カラフルな赤 */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ffd93d; /* 明るい黄色 */
        }

        h2 {
            margin-top: 30px;
            color: #ff6b6b; /* カラフルな赤 */
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: rgba(245, 245, 245, 0.8);
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        li button {
            background-color: #66bb6a; /* グリーン */
        }

        li button:hover {
            background-color: #81c784; /* 明るいグリーン */
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
    <h1>プランカスタマイズ</h1>

    <form method="post">
        <label for="invite_email">招待するメンバー:</label>
        <input type="email" id="invite_email" name="invite_email" required>
        <button type="submit">招待する</button>
    </form>

    <h2>カスタマイズするプランを選択</h2>
    <ul>
        <?php while ($row = $plans_result->fetch_assoc()) { ?>
            <li>
                <?php echo $row['destination'] . " - " . $row['start_date'] . " 〜 " . $row['end_date']; ?>
                <form action="customize.php" method="get" style="display:inline;">
                    <input type="hidden" name="plan_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">カスタマイズする</button>
                </form>
            </li>
        <?php } ?>
    </ul>
</main>

<script>
function confirmLogout() {
    if (confirm("本当にログアウトしますか？")) {
        window.location.href = "logout.php";
    }
}
</script>

</body>
</html>
<?php
$conn->close();
?>
