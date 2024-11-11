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
$action = $_POST['action'];

if ($action === "add") {
    // お気に入りに追加
    $sql = "INSERT INTO user_favorites (user_id, plan_id) VALUES ('$user_id', '$plan_id')";
} elseif ($action === "remove") {
    // お気に入りから削除
    $sql = "DELETE FROM user_favorites WHERE user_id='$user_id' AND plan_id='$plan_id'";
}

if ($conn->query($sql) === TRUE) {
    echo "操作成功";
} else {
    echo "エラー: " . $conn->error;
}

$conn->close();
?>
