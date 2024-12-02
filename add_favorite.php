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

if (!isset($_SESSION['user_id'])) {
    echo "エラー: ユーザーがログインしていません。";
    exit;
}

if (!isset($_POST['plan_id']) || !isset($_POST['action'])) {
    echo "エラー: 必要なデータが送信されていません。";
    exit;
}

$user_id = $conn->real_escape_string($_SESSION['user_id']);
$plan_id = $conn->real_escape_string($_POST['plan_id']);
$action = $conn->real_escape_string($_POST['action']);

if ($action === "add") {
    $sql = "INSERT INTO user_favorites (user_id, plan_id) VALUES ('$user_id', '$plan_id')";
} elseif ($action === "remove") {
    $sql = "DELETE FROM user_favorites WHERE user_id='$user_id' AND plan_id='$plan_id'";
} else {
    echo "エラー: 不正な操作です。";
    exit;
}

if ($conn->query($sql) === TRUE) {
    echo "操作成功";
} else {
    echo "エラー: " . $conn->error;
}

$conn->close();
?>
