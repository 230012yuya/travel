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

$user = $_POST['name'];
$pass = $_POST['password'];

$sql = "SELECT * FROM user WHERE name='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $user;
        header("Location: home.php");
        exit;
    } else {
        echo "無効なパスワードです";
    }
} else {
    echo "無効なユーザー名です";
}

$conn->close();
?>
