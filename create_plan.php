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
    <style>
        .form-row:nth-child(odd) {
            background-color: #f2f2f2; /* 明るい灰色 */
        }
        .form-row:nth-child(even) {
            background-color: #e6e6e6; /* 少し濃い灰色 */
        }
        .form-row {
            padding: 10px;
            margin-bottom: 5px;
        }
        .form-row input,
        .form-row textarea {
            width: calc(100% - 20px); /* 余白を含む */
        }
    </style>
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
            <div class="form-row">
                <label for="departure_point">出発地点:</label>
                <input type="text" id="departure_point" name="departure_point" required>
            </div>
            
            <div class="form-row">
                <label for="destination">目的地:</label>
                <input type="text" id="destination" name="destination" required>
            </div>
            
            <div class="form-row">
                <label for="start_date">開始日:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            
            <div class="form-row">
                <label for="end_date">終了日:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            
            <div class="form-row">
                <label for="number_of_people">人数:</label>
                <input type="number" id="number_of_people" name="number_of_people" min="1" required>
                <span>人</span>
            </div>
            
            <div class="form-row">
                <label for="budget">予算:</label>
                <input type="number" id="budget" name="budget" step="1" min="0" required>
                <span>円</span>
            </div>
            
            <div class="form-row">
                <label for="details">詳細:</label>
                <textarea id="details" name="details" required></textarea>
            </div>
            
            <button type="submit">作成</button>
        </form>
    </main>
</body>
</html>
