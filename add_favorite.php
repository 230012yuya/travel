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

$user_id = $_SESSION['user_id'];
$plan_id = $_POST['plan_id'];

// お気に入りに追加するクエリ
$sql = "INSERT INTO user_favorites (user_id, plan_id) VALUES ('$user_id', '$plan_id')";

// 実行とエラーチェック
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('プランがお気に入りに追加されました！'); window.location.href='view_plans.php';</script>";
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
