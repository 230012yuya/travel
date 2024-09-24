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
            background-color: #f0f9ff; /* 柔らかいパステルブルー */
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9); /* 少し濃い目の背景 */
            padding: 0 15px;
            font-size: 18px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9; /* 柔らかいピンク */
            color: #fff;
            transform: scale(1.05); /* ホバー時の動き */
        }

        /* Traveeelタイトル */
    .title {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 50px;
        font-weight: bold;
        background: linear-gradient(45deg, #ff6b6b, #ffd93d, #6bc9ff);
        -webkit-background-clip: text;
        color: transparent;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .title:hover {
        transform: scale(1.1) rotate(5deg);
        text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 0, 0, 0.7); /* 影を強調 */
    }


        main {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* 半透明の背景 */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ff6b6b; /* カラフルな赤 */
            font-size: 28px; /* タイトルサイズ */
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none; /* リストのスタイルをなしに */
            padding: 0;
        }

        li {
            background-color: #e3f2fd; /* 各プランの背景色 */
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            transition: transform 0.2s;
        }

        li:hover {
            transform: scale(1.02); /* ホバー時に少し拡大 */
        }

    </style>
</head>
<body style="font-family: 'Roboto', sans-serif; margin: 0; padding: 0; background-color: #f0f9ff; color: #333; display: flex; flex-direction: column; min-height: 100vh;">

    <div class="navbar" id="myNavbar" style="overflow: hidden; background-color: rgba(50, 50, 70, 0.9); padding: 0 15px; font-size: 18px;">
        <a href="home.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">ホーム</a>
        <a href="create_plan.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">旅行プラン作成</a>
        <a href="view_plans.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">旅行プラン表示</a>
        <a href="profile.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">プロフィール</a>
        <a href="view_plans.php" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">過去の旅行プラン</a>
        <a href="javascript:void(0);" onclick="confirmLogout()" style="float: left; display: block; color: white; text-align: center; padding: 14px 20px; text-decoration: none; font-weight: bold; transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;">ログアウト</a>
    </div>

    <div class="title" style="position: absolute; top: 10px; right: 20px; font-size: 50px; font-weight: bold; background: linear-gradient(45deg, #ff6b6b, #ffd93d, #6bc9ff); -webkit-background-clip: text; color: transparent; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); transition: transform 0.3s ease;">Traveeel</div>

    <div class="form-container" style="max-width: 800px; max-height: 90vh; margin: 50px auto; padding: 30px; background-color: rgba(255, 255, 255, 0.9); border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow-y: auto;">
        <h1 style="text-align: center; color: #ff6b6b; font-size: 28px; margin-bottom: 30px;">旅行プラン作成</h1>
        <form action="save_plan.php" method="post">
            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="departure_point" style="margin-bottom: 8px; font-size: 16px; color: #333;">出発地点:</label>
                <input type="text" id="departure_point" name="departure_point" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="destination" style="margin-bottom: 8px; font-size: 16px; color: #333;">目的地:</label>
                <input type="text" id="destination" name="destination" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="start_date" style="margin-bottom: 8px; font-size: 16px; color: #333;">開始日:</label>
                <input type="date" id="start_date" name="start_date" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="end_date" style="margin-bottom: 8px; font-size: 16px; color: #333;">終了日:</label>
                <input type="date" id="end_date" name="end_date" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="number_of_people" style="margin-bottom: 8px; font-size: 16px; color: #333;">人数:</label>
                <input type="number" id="number_of_people" name="number_of_people" min="1" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="budget" style="margin-bottom: 8px; font-size: 16px; color: #333;">予算:</label>
                <input type="number" id="budget" name="budget" step="1" min="0" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%;">
            </div>

            <div class="form-row" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                <label for="details" style="margin-bottom: 8px; font-size: 16px; color: #333;">詳細:</label>
                <textarea id="details" name="details" required style="padding: 12px; font-size: 16px; border: 1px solid #ffb6b9; border-radius: 5px; background-color: #f9f9f9; transition: border-color 0.3s; width: 100%; height: 100px; resize: vertical;"></textarea>
            </div>

            <button type="submit" style="width: 100%; padding: 15px; font-size: 18px; font-weight: bold; background-color: #ff6b6b; color: white; border: none; border-radius: 10px; cursor: pointer; transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;">
                作成
            </button>
        </form>
    </div>

    <script>
        // ログアウト確認ダイアログ
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php"; // OKが押された場合はログアウト
            }
        }
    </script>
</body>
</html>
