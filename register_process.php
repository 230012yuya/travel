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
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO user (name, email, password) VALUES ('$user', '$email', '$pass')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['loggedin'] = true;
    $_SESSION['name'] = $user;
    header("Location: home.php");
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
