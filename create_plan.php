<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン作成</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f0f4f8; /* 背景色を柔らかく */
        }

        .navbar {
            background-color: #3f51b5;
            padding: 10px;
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
            font-weight: 500;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #3f51b5;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .form-row label {
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        .form-row input,
        .form-row textarea {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        .form-row input:focus,
        .form-row textarea:focus {
            border-color: #3f51b5;
        }

        .form-row textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: 500;
            background-color: #3f51b5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #303f9f;
        }

        /* レスポンシブデザイン */
        @media (max-width: 600px) {
            .navbar {
                font-size: 14px;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="view_plans.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <a href="logout.php">ログアウト</a>
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
            </div>

            <div class="form-row">
                <label for="budget">予算:</label>
                <input type="number" id="budget" name="budget" step="1" min="0" required>
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
