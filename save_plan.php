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
$departure_point = $_POST['departure_point'];
$destination = $_POST['destination'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$number_of_people = $_POST['number_of_people'];
$budget = $_POST['budget'];
$details = $_POST['details'];

$sql = "INSERT INTO plans (user_id, departure_point, destination, start_date, end_date, number_of_people,budget, details) VALUES ('$user_id', '$departure_point','$destination', '$start_date', '$end_date', '$number_of_people', '$budget', '$details')";

if ($conn->query($sql) === TRUE) {
    header("Location: view_plans.php");
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
