<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン作成</title>
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
        <h1>旅行プラン作成</h1>
        <form action="save_plan.php" method="post">
            <label for="destination">目的地:</label>
            <input type="text" id="destination" name="destination" required>
            
            <label for="start_date">開始日:</label>
            <input type="date" id="start_date" name="start_date" required>
            
            <label for="end_date">終了日:</label>
            <input type="date" id="end_date" name="end_date" required
