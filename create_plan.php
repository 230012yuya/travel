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
        body {
            position: relative;/* ボディに対して相対的な位置指定を行う */
            font-family: Arial, sans-serif; 
        }
        .home-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            color: #333;
            z-index: 1000; /* 必要に応じて調整 */
        }
        .home-button img {
            width: 80%;
            height: auto;
        }
        
        .form-container {
            margin-top: 100px; /* ホームボタンの分だけ下にずらす */
            padding: 20px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
        }
        
        .form-row {
            padding: 10px;
            margin-bottom: 5px;
        }
        .form-row input,
        .form-row textarea {
            width: calc(100% - 20px); /* 余白を含む */
        }
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar .icon {
            display: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        @media screen and (max-width: 600px) {
            .navbar a:not(:first-child) {display: none;}
            .navbar a.icon {
                float: right;
                display: block;
            }
        }
        @media screen and (max-width: 600px) {
            .navbar.responsive {position: relative;}
            .navbar.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .navbar.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="navbar" id="myNavbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="view_plans.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <a href="logout.php">ログアウト</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            &#9776;
        </a>
    </div>

    <div class="form-container">
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
    </div>
</body>
</html>
