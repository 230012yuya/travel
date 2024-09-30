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
            padding: 20px;
            background-color: #f0f9ff;
        }
        .plan-detail {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="plan-detail">
        <h1><?php echo $plan['plan_name']; ?></h1>
        <p>出発日: <?php echo $plan['start_date']; ?></p>
        <p>帰着日: <?php echo $plan['end_date']; ?></p>
        <p>詳細: <?php echo $plan['details']; ?></p>
        <a href="view_plans.php">戻る</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>